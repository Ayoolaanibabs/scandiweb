import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import Footer from '../components/Footer';
import {
  reset,
  getAllProduct,
  deleteProduct,
} from '../features/product/productSlice';
import { PRODUCT_TYPES, ROUTES } from '../utilities/constants';

const ProductListPage = () => {
  const navigate = useNavigate();
  const dispatch = useDispatch();

  const { products, isError, message } = useSelector((state) => state.product);
  const massDelete = () => {
    var x = document.getElementsByClassName('delete-checkbox');
    const arr = [];
    for (let i = 0; i < x.length; i++) {
      if (x[i].checked) {
        arr.push(x[i].id);
      }
    }
    dispatch(deleteProduct(arr));
  };
  useEffect(() => {
    if (isError) {
      console.log(message);
    }
    dispatch(getAllProduct());
    return () => {
      dispatch(reset());
    };
  }, [navigate, isError, message, dispatch]);

  return (
    <>
      <div className="container">
        <header>
          <div className="heading">Product List</div>
          <div style={{ padding: '15px' }}>
            <button onClick={() => navigate(ROUTES.ADD_PRODUCT)}>ADD</button>
            <button id="delete-product-btn" onClick={massDelete}>
              MASS DELETE
            </button>
          </div>
        </header>
        <hr />
        {products.length > 0 ? (
          <div className="grid">
            {products.map((product, index) => (
              <div className="box" key={index}>
                <label htmlFor={product.id}>
                  <input
                    className="delete-checkbox"
                    type="checkbox"
                    id={product.id}
                    name={product.name}
                    value={product.id}
                  />
                  <br />
                  <div className="box-text">
                    <p>{product.sku && product.sku}</p>
                    <p>{product.name && product.name}</p>
                    <p>{(product.price | 0).toFixed(2)}$</p>
                    {product.type === PRODUCT_TYPES.BOOK && product.weight && (
                      <p>Weight: {product.weight} KG</p>
                    )}
                    {product.type === PRODUCT_TYPES.DVD && product.size && (
                      <p>Size: {product.size} MB</p>
                    )}
                    {product.type === PRODUCT_TYPES.FURNITURE &&
                      product.height &&
                      product.width &&
                      product.length && (
                        <p>
                          Dimension: {product.height} x {product.width} x{' '}
                          {product.length}
                        </p>
                      )}
                  </div>
                </label>
              </div>
            ))}
          </div>
        ) : (
          <div>No Product Availabe kindly Add Products</div>
        )}
      </div>
      <Footer />
    </>
  );
};

export default ProductListPage;
