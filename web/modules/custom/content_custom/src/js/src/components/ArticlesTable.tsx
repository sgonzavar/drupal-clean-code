import React, { useState, useEffect } from 'react';
import { DragDropContext, Droppable, Draggable, DropResult } from 'react-beautiful-dnd';
import './ArticlesTable.css';

interface ContactInfo {
  date: string;
  firstName: string;
  lastName: string;
  phoneNumber: string;
  email: string;
}

interface Article {
  id: number;
  title: string;
  body: string;
  taxonomy: string;
  contactInfo: ContactInfo;
}

const ArticlesTable: React.FC = () => {
  const [articles, setArticles] = useState<Article[]>([]);

  useEffect(() => {
    fetch('/api/articles')
      .then(response => response.json())
      .then(data => setArticles(data))
      .catch(error => console.error('Error:', error));
  }, []);

  const onDragEnd = (result: DropResult) => {
    if (!result.destination) {
      return;
    }

    const items = Array.from(articles);
    const [reorderedItem] = items.splice(result.source.index, 1);
    items.splice(result.destination.index, 0, reorderedItem);

    setArticles(items);
  };

  return (
    <DragDropContext onDragEnd={onDragEnd}>
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
        <Droppable droppableId="articles">
          {(provided) => (
            <tbody {...provided.droppableProps} ref={provided.innerRef}>
            {articles.map((article, index) => (
              <Draggable key={article.id} draggableId={article.id.toString()} index={index}>
                {(provided) => (
                  <tr
                    ref={provided.innerRef}
                    {...provided.draggableProps}
                    {...provided.dragHandleProps}
                  >
                    <td>{article.title}</td>
                    <td>{article.taxonomy}</td>
                    <td>{article.contactInfo.firstName}</td>
                    <td>{article.contactInfo.lastName}</td>
                    <td>{article.contactInfo.email}</td>
                    <td>{article.contactInfo.phoneNumber}</td>
                  </tr>
                )}
              </Draggable>
            ))}
            {provided.placeholder}
            </tbody>
          )}
        </Droppable>
      </table>
    </DragDropContext>
  );
};

export default ArticlesTable;
