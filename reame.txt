# Jumbotron Blog Block Plugin for Moodle

## Overview

The Jumbotron Blog block plugin highlights the latest blog post in a stylish jumbotron/banner format. This plugin displays the most recent blog post with its title, a brief summary, the author's name, the post date, and an image if available.

## Features

- Displays the newest blog post.
- Shows post title, summary, author, date, and associated image.
- Automatically calculates and displays the age of the post in days.
- Includes a "Read More" link to the full blog post.

## Installation

1. **Download or Clone the Plugin**
   - Download the plugin from the repository or clone it using Git:
     ```sh
     git clone https://github.com/your-repository/jumbotron_blog.git
     ```

2. **Upload to Moodle**
   - Copy the `jumbotron_blog` folder to the `blocks` directory of your Moodle installation.

3. **Install the Plugin**
   - Log in to your Moodle site as an admin.
   - Navigate to `Site administration` -> `Notifications` to install the plugin.
   - Follow the on-screen instructions to complete the installation.

4. **Add the Block**
   - Go to a page where you want to add the block (e.g., a course page).
   - Turn editing on.
   - Add the "Jumbotron Blog" block from the "Add a block" menu.

## Configuration

No additional configuration is required. The plugin will automatically fetch and display the latest blog post.

## Files

- `block_jumbotron_blog.php`: The main block plugin file.
- `version.php`: Plugin version information.
- `lang/en/block_jumbotron_blog.php`: Language strings.
- `styles.css`: CSS styles.

