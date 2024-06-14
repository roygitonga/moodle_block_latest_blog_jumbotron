<?php
defined('MOODLE_INTERNAL') || die();

class block_jumbotron_blog extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_jumbotron_blog');
    }

    public function get_content() {
        global $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        // Initialize content as an empty object
        $this->content = new stdClass();
        $this->content->text = '';

        // Fetch the latest blog post with image
        $sql = "
            SELECT
                u.id AS user_id,
                u.firstname,
                u.lastname,
                p.id AS post_id,
                p.subject,
                p.summary AS content,
                p.created,
                f.filename,
                f.contenthash,
                CONCAT('/pluginfile.php/', f.contextid, '/blog/attachment/', f.itemid, '/', f.filename) AS image_url
            FROM
                mdl_post p
            JOIN
                mdl_user u ON p.userid = u.id
            JOIN
                mdl_files f ON p.id = f.itemid AND f.component = 'blog' AND f.filearea = 'attachment'
            WHERE
                p.created = (
                    SELECT MAX(created)
                    FROM mdl_post
                    WHERE userid = u.id
                )
            ORDER BY
                p.created DESC
            LIMIT 1;
        ";
        $latestpost = $DB->get_record_sql($sql);

        if ($latestpost) {
            $date = userdate($latestpost->created);
            $title = format_string($latestpost->subject);
            $content = format_text($latestpost->content);
            $intro = substr(strip_tags($content), 0, 200);
            $author = fullname($latestpost);

            // Calculate the difference in days
            $now = time(); // Current timestamp
            $datediff = $now - $latestpost->created; // Difference in seconds
            $days = floor($datediff / (60 * 60 * 24)); // Convert seconds to days

            // Construct the URL to the full blog post
            $url = new moodle_url('/blog/index.php', array('entryid' => $latestpost->post_id));

            // Generate the HTML content
            $this->content->text = <<<HTML
<section class="blog_front_hero-main">
  <div class="blog_front_hero-container">
    <article class="blog_front_hero-content">
      <div class="blog_front_hero-article">
        <div class="blog_front_hero-meta">
          <span class="blog_front_hero-newest">Newest Blog</span>
          <time class="blog_front_hero-date" datetime="$date">$days Days ago</time>
        </div>
        <h2 class="blog_front_hero-title">$title</h2>
        <p class="blog_front_hero-description">$intro</p>
        <a class="blog_front_hero-read-more" href="$url">Read Article</a>
      </div>
    </article>
    <div class="blog_front_hero-content-wrapper">
      <img class="blog_front_hero-blog-image-large" src="$latestpost->image_url" alt="$title" loading="lazy">
    </div>
  </div>
</section>
HTML;
        } else {
            $this->content->text = get_string('noblogposts', 'block_jumbotron_blog');
        }

        $this->content->footer = '';

        // Enqueue CSS
        $this->page->requires->css(new moodle_url('/blocks/jumbotron_blog/style.css'));

        return $this->content;
    }
}
