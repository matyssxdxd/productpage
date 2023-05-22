import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
import AddProduct from "./components/AddProduct";
import ListProducts from "./components/ListProducts";
import './App.css';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route index element={<ListProducts />} />
        <Route path="/addproduct" element={<AddProduct />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
