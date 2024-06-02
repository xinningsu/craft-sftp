<p align="center"><img src="./src/icon.svg" width="100" height="100" alt="SFTP integration for Craft CMS"></p>

<h1 align="center">SFTP integration for Craft CMS</h1>

This plugin provides a SFTP integration for [Craft CMS](https://craftcms.com/), with this plugin we can create a SFTP volume type for Craft CMS.

## Requirements

- PHP 8.2 or later
- Craft CMS 5.0 or later

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “SFTP Volume”. Then press **Install** in its modal window.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project

# tell Composer to load the plugin
composer require xinningsu/craft-sftp

# tell Craft to install the plugin
./craft plugin/install craft-sftp
```

## Setup

To create a new SFTP filesystem to use with your volumes,

- Login admin, visit **Settings** → **Filesystems**,
- Press **New filesystem**.
- Select “SFTP” for the **Filesystem Type**
- Setting and configure as needed.
