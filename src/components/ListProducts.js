import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import Item from "./Item.js";
import "../styles/ListProducts.css";

const ListProducts=()=> {

    const [products, setProducts] = useState([]);

    const [selected, setSelected] = useState([]);

    useEffect(() => {
        getProducts();
    }, []);

    const getProducts=()=> {
        axios.get("http://localhost/api/product/get")
        .then(response => {
            setProducts(response.data);
        })
    }

    const handleItemChange = (itemId, isChecked) => {
        if(isChecked) {
            setSelected([...selected, itemId]);
        } else {
            setSelected(selected.filter(id => id !== itemId));
        }
    }

    const massDelete=()=>{
        if(selected.length !== 0) {
            selected.forEach(id => {
                axios.delete(`http://localhost/api/product/delete/${id}`)
                .then(response=> {
                    console.log(response.data);
                    selected.pop(id);
                    getProducts();
                });
            })
            console.log(selected);
        }
    }

    return (
        <div className="container">
            <div className="nav">
                <div className="nav-content">
                    <h1>Product List</h1>
                    <div className="nav-btn">
                        <Link to="/addproduct">
                            <button>
                                ADD
                            </button>
                        </Link>
                        <button onClick={massDelete}>
                            DELETE
                        </button>
                    </div>
                </div>
            </div>
            <div className="item-container">
            {products && products.length > 0 ? ( products.map((product) => {
                    return product.type === "dvd" ? 
                         <Item key={product.sku} type={product.type} sku={product.sku} name={product.name} price={product.price} size={product.size} onChange={handleItemChange} /> :
                        product.type === "book" ? 
                        <Item key={product.sku} type={product.type} sku={product.sku} name={product.name} price={product.price} weight={product.weight} onChange={handleItemChange} /> :
                        product.type === "furniture" ?
                        <Item key={product.sku} type={product.type} sku={product.sku} name={product.name} price={product.price} height={product.height} width={product.width} length={product.length} onChange={handleItemChange} /> :
                        null;
                })) : null}
            </div>
        </div>
    )
}

export default ListProducts;