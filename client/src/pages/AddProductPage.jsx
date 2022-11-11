import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { createProduct, getAllProduct, setStatus } from '../features/product/productSlice';
import Footer from '../components/Footer';
import { PRODUCT_TYPES, ROUTES } from '../utilities/constants';

const AddProductPage = () => {
  const [productData, setProductData] = useState({
    name: '',
    type: '',
    sku: '',
    price: undefined,
    size: undefined,
    weight: undefined,
    height: undefined,
    width: undefined,
    length: undefined,
  });
  const { status } = useSelector((state) => state.product);
  const [skuErr, setSkuErr] = useState('');
  const { name, type, sku, price, size, weight, height, width, length } =
    productData;
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const onChange = (e) => {
    setProductData((prevState) => ({
      ...prevState,
      [e.target.name]: e.target.value,
    }));
  };

  const onSubmit = (e) => {
    e.preventDefault();
    const data = {
      name,
      type,
      sku,
      price: parseFloat(price),
      size: parseFloat(size),
      weight: parseFloat(weight),
      height: parseFloat(height),
      width: parseFloat(width),
      length: parseFloat(length),
    };
    dispatch(createProduct(data));
  };

  useEffect(() => {
    if (status === 400) {
      setSkuErr('SKU already exists for another product');
    } else if (status === 200) {
      dispatch(setStatus());
      dispatch(getAllProduct());
      navigate(ROUTES.HOME);
    }
  }, [status, dispatch, navigate]);

  return (
    <>
      <div className="container">
        <form id="product_form" onSubmit={onSubmit}>
          <header>
            <div className="heading">Product Add</div>
            <div style={{ padding: '15px' }}>
              <button type="submit">Save</button>
              <button onClick={() => navigate(ROUTES.HOME)}>Cancel</button>
            </div>
          </header>
          <hr />
          <section className="form">
            <div className="form-group">
              <label>SKU</label>
              <input
                type="text"
                className="form-control"
                id="sku"
                name="sku"
                placeholder="Enter sku"
                onChange={onChange}
                value={sku}
                required
              />
            </div>
            <div>
              <p className="error_message">{skuErr}</p>
            </div>
            <div className="form-group">
              <label>Name</label>
              <input
                type="text"
                className="form-control"
                id="name"
                name="name"
                placeholder="Enter product name"
                onChange={onChange}
                value={name}
                required
              />
            </div>
            <div className="form-group">
              <label>Price ($)</label>
              <input
                type="number"
                className="form-control"
                id="price"
                name="price"
                placeholder="Enter product price"
                value={price}
                onChange={onChange}
                required
              />
            </div>
            <div className="form-group">
              <label htmlFor="type">Type Switcher</label>
              <select id="productType" name="type" onChange={onChange} required>
                <option value="">None</option>
                <option id="DVD" value="DVD">
                  DVD
                </option>
                <option id="Furniture" value="Furniture">
                  Furniture
                </option>
                <option id="Book" value="Book">
                  Book
                </option>
              </select>
            </div>
            {type === PRODUCT_TYPES.DVD && (
              <>
                <div className="form-group">
                  <label>Size (MB)</label>
                  <input
                    type="number"
                    className="form-control"
                    id="size"
                    name="size"
                    placeholder="Enter DVD Size"
                    value={size}
                    onChange={onChange}
                    required
                  />
                </div>
                <p style={{ textAlign: 'left' }}>
                  Please Provide the size of the DVD{' '}
                </p>
              </>
            )}
            {type === PRODUCT_TYPES.FURNITURE && (
              <>
                <div className="form-group">
                  <label>Height (CM)</label>
                  <input
                    type="number"
                    className="form-control"
                    id="height"
                    name="height"
                    placeholder="Enter Furniture height"
                    value={height}
                    onChange={onChange}
                    required
                  />
                </div>
                <div className="form-group">
                  <label>Width (CM)</label>
                  <input
                    type="number"
                    className="form-control"
                    id="width"
                    name="width"
                    placeholder="Enter Furniture width"
                    value={width}
                    onChange={onChange}
                    required
                  />
                </div>
                <div className="form-group">
                  <label>Length (CM)</label>
                  <input
                    type="number"
                    step={0.01}
                    className="form-control"
                    id="length"
                    name="length"
                    value={length}
                    placeholder="Enter Furniture Length"
                    onChange={onChange}
                    required
                  />
                </div>
                <p style={{ textAlign: 'left' }}>
                  Please Provide dimensions in HxWxL format{' '}
                </p>
              </>
            )}
            {type === PRODUCT_TYPES.BOOK && (
              <>
                <div className="form-group">
                  <label>Weight (KG)</label>
                  <input
                    type="number"
                    className="form-control"
                    id="weight"
                    name="weight"
                    value={weight}
                    placeholder="Enter Book Weight"
                    onChange={onChange}
                    required
                  />
                </div>
                <p style={{ textAlign: 'left' }}>
                  Please Provide the weight of the Book{' '}
                </p>
              </>
            )}
          </section>
        </form>
      </div>
      <Footer />
    </>
  );
};

export default AddProductPage;
