# Statamic Image Palette

![Statamic 3.0+](https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge&link=https://statamic.com)


## Features
- Automatically grab the **color palette** from your image assets.
- Update existing image assets using integrated **command**.
- Access palette colors in **antlers**.
- **Preview palette** when editing an image


## Getting Started

We have made things easy for you start. Here is the three steps your need to follow:

1. **Install the addon**
   Simply run `composer require enyancc/image-palette`
   You also can follow [official Statamic help guide](https://statamic.dev/addons#installing-addons)


2. **Generate palette for existing assets.**
   If you already started uploading assets, it is very easy to add palette, run `php please imagepalette:generate`.

3. **Use it.**
    Access palette colors in your antlers templates using `{{ asset:palette }}` iterator


<!-- ## What does your addon look like? -->

## Changelog

**1.0.0**
🚀 Initial release.