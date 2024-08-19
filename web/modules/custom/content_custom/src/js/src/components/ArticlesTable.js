import React, { useState, useEffect } from 'react';

const ArticlesTable = () => {
  const [articles, setArticles] = useState([]);

  useEffect(() => {
    fetch('/api/articles')
      .then(response => response.json())
      .then(data => setArticles(data))
      .catch(error => console.error('Error:', error));
  }, []);

  return (
    <table>
      <thead>
      <tr>
        <th>Title</th>
        <th>Taxonomy</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
      </tr>
      </thead>
      <tbody>
      {articles.map(article => (
        <tr key={article.id}>
          <td>{article.title}</td>
          <td>{article.taxonomy}</td>
          <td>{article.contactInfo.firstName}</td>
          <td>{article.contactInfo.lastName}</td>
          <td>{article.contactInfo.email}</td>
          <td>{article.contactInfo.phoneNumber}</td>
        </tr>
      ))}
      </tbody>
    </table>
  );
};

export default ArticlesTable;
