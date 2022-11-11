import axios from 'axios';

import { BASE_URL} from '../../utilities/constants';

// Get all Products
const getAllProduct = async () => {
  const response = await axios.get(BASE_URL);
  return response.data;
};

// Create a product
const createProduct = async (productInfo) => {
  // const response = await axios.post(BASE_URL, productInfo);
  const response = await fetch(BASE_URL, {
    method: 'POST',
    body: JSON.stringify(productInfo),
  });
  return response.status;
};

const deleteProduct = async (productList) => {
  // const response = await axios.delete(BASE_URL, { data: { productList } });
  // Use a post method instead of delete due to restrictions with the deployment host
  const response = await fetch(BASE_URL + '/delete', {
    method: 'POST',
    body: JSON.stringify({ productList }),
  });
  return response.data;
};

const productService = {
  getAllProduct,
  createProduct,
  deleteProduct,
};

export default productService;
