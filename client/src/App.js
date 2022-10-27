import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import './App.css';
import AddProductPage from './pages/AddProductPage';
import ProductListPage from './pages/ProductListPage';
import { ROUTES } from './utilities/constants';

function App() {
  return (
    <>
      <Router>
        <Routes>
          <Route path={ROUTES.HOME} element={<ProductListPage />} />
          <Route path={ROUTES.ADD_PRODUCT} element={<AddProductPage />} />
        </Routes>
      </Router>
    </>
  );
}

export default App;
