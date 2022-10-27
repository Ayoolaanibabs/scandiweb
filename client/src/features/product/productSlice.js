import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import productService from './productService';

const initialState = {
  products: [],
  isError: false,
  isSuccess: false,
  isLoading: false,
  message: '',
};

// Get all product
export const getAllProduct = createAsyncThunk(
  'product/getAll',
  async (_, thunkAPI) => {
    try {
      const response = await productService.getAllProduct();
      return response;
    } catch (error) {
      const message =
        (error.response &&
          error.response.data &&
          error.response.data.message) ||
        error.message ||
        error.toString();
      return thunkAPI.rejectWithValue(message);
    }
  }
);

// Create new product
export const createProduct = createAsyncThunk(
  'product/create',
  async (productData, thunkAPI) => {
    try {
      const response = await productService.createProduct(productData);
      return response;
    } catch (error) {
      const message =
        (error.response &&
          error.response.data &&
          error.response.data.message) ||
        error.message ||
        error.toString();
      return thunkAPI.rejectWithValue(message);
    }
  }
);

// Mass Delete product
export const deleteProduct = createAsyncThunk(
  'product/delete',
  async (productList, thunkAPI) => {
    try {
      const response = await productService.deleteProduct(productList);
      return response;
    } catch (error) {
      const message =
        (error.response &&
          error.response.data &&
          error.response.data.message) ||
        error.message ||
        error.toString();
      return thunkAPI.rejectWithValue(message);
    }
  }
);

export const productSlice = createSlice({
  name: 'product',
  initialState,
  reducers: {
    reset: (state) => {
      state = initialState;
    },
  },
  extraReducers: (builder) => {
    builder
      .addCase(getAllProduct.pending, (state) => {
        state.isLoading = true;
      })
      .addCase(getAllProduct.fulfilled, (state, action) => {
        state.isLoading = false;
        state.isSuccess = true;
        state.products = action.payload;
      })
      .addCase(getAllProduct.rejected, (state, action) => {
        state.isLoading = false;
        state.isError = true;
      })
      .addCase(createProduct.pending, (state) => {
        state.isLoading = true;
      })
      .addCase(createProduct.fulfilled, (state, action) => {
        state.isLoading = false;
        state.isSuccess = true;
        // state.products.push(action.payload);
      })
      .addCase(createProduct.rejected, (state) => {
        state.isLoading = false;
        state.isError = true;
      })
      .addCase(deleteProduct.pending, (state) => {
        state.isLoading = true;
      })
      .addCase(deleteProduct.fulfilled, (state, action) => {
        state.isLoading = false;
        state.isSuccess = true;
        state.products = state.products.filter(function (array_el) {
          return (
            action.meta.arg.filter(function (anotherOne_el) {
              return anotherOne_el === array_el.id;
            }).length === 0
          );
        });
        console.log(state.products);
      })
      .addCase(deleteProduct.rejected, (state) => {
        state.isLoading = false;
        state.isError = true;
      });
  },
});

export const { reset } = productSlice.actions;
export default productSlice.reducer;
