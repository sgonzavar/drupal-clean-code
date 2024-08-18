
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


## Endpoints
The module exposes the following RESTful endpoints:

POST /api/article: Creates a new article.
GET /api/article/{id}: Retrieves a specific article by its ID.
GET /api/articles: Retrieves a list of all articles.
PUT /api/article/{id}: Updates a specific article by its ID.
DELETE /api/article/{id}: Deletes a specific article by its ID.

## Usage
### Creating an Article
To create an article, send a POST request to /api/article with the required data in the request body.

Retrieving Articles
- To get a list of articles, send a GET request to /api/articles.
- To get a specific article, send a GET request to /api/article/{id}.

### Contributing
If you'd like to contribute to the article_custom module, please follow these steps:

Fork the repository.
- Create a new branch with your feature or bug fix:
  - git checkout -b feature/your-feature-name
- Commit your changes:
  - git commit -m "Add your commit message here"
- Push to the branch:
  - git push origin feature/your-feature-name
