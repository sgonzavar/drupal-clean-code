
# Article Custom Module

## Overview

The `article_custom` module provides endpoints with basic CRUD functionalities (Create, Read, Update, Delete) for handling articles in Drupal. The module indirectly implements clean architecture principles to ensure maintainable and scalable code.

## Features

- **Create**: Allows the creation of new articles via a dedicated endpoint.
- **Read**: Provides endpoints to retrieve articles, either a single article by ID or a list of articles.
- **Update**: Enables the updating of existing articles through an endpoint.
- **Delete**: Supports the deletion of articles via an endpoint.

## Installation

1. Place the `article_custom` module in the `modules/custom/` directory of your Drupal installation.
2. Enable the module using the following Drush command:
   ```bash
   drush en article_custom -y
