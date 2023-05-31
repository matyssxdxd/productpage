import { Link, useNavigate } from "react-router-dom";
import { useState } from "react";
import axios from "axios";
import "../styles/AddProduct.css";

const AddProduct=()=> {

    const navigate = useNavigate();

    const options = [
        {value: "", text:"Select product type"},
        {value: "DVD", text:"DVD"},
        {value: "Book", text:"Book"},
        {value: "Furniture", text:"Furniture"},
    ];

    const [selected, setSelected] = useState(options[0].value);
    const [inputs, setInputs] = useState({});
    const [attributes, setAttributes] = useState([]);
    const [error, setError] = useState();


    const handleChange=(event)=> {
        const name = event.target.name;
        const value = event.target.value;
        if (["weight", "size", "height", "length", "width"].includes(name)) {
            setAttributes(attributes => ({...attributes, [name]: value}));
        } else {
            setInputs(values => ({...values, [name]: value}));
        }
    
    }

    const handleType=(event)=>{
        setSelected(event.target.value);
        setAttributes([]);
        handleChange(event);
    }

    const handleSubmit=(event)=> {
        event.preventDefault();
        axios.post("https://product-page.x10.mx/api/product/save", {inputs, attributes})
        .then(response => {
            if(response.data.status === 0) {
                setError(response.data.message);
            } else if (response.data.status === 1) {
                navigate("/");
            }
        })
        .catch(error => {
            console.log(error);
        })
    }

    return (
        <div className="container">
            <div className="nav">
                <div className="nav-content">
                    <h1>Product Add</h1>
                    <div className="nav-btn">
                        <button form="product_form">
                            Save
                        </button>
                        <Link to="/">
                            <button>
                                Cancel
                            </button>
                        </Link>
                    </div>
                </div>
            </div>
            <div className="form-container">
                {error !== "" ? (
                        <div className="error-message">{error}</div>
                    ) : null}
                <form id="product_form" className="product-form" onSubmit={handleSubmit}>
                    <input type="text" id="sku" name="sku" placeholder="SKU" onChange={handleChange} />
                    <input type="text" id="name" name="name" placeholder="Name" onChange={handleChange} />
                    <input type="text" id="price" name="price" placeholder="Price" onChange={handleChange} />
                    <select value={selected} id="productType" name="type" onChange={handleType}>
                        {options.map(option => (
                            <option key={option.value} value={option.value}>
                                {option.text}
                            </option>
                        ))}
                    </select>
                    {selected === "DVD" ? (
                        <div className="selected">
                            <input type="text" id="size" name="size" placeholder="Size" onChange={handleChange} />
                            <p className="description">Please, provide size</p>
                        </div>
                        ) : selected  === "Book" ? (
                        <div className="selected">
                            <input type="text" id="weight" name="weight" placeholder="Weight" onChange={handleChange} />
                            <p className="description">Please, provide weight</p>
                        </div>
                        ) : selected  === "Furniture" ? (
                        <div className="selected">
                            <input type="text" id="height" name="height" placeholder="Height" onChange={handleChange} />
                            <input type="text" id="width" name="width" placeholder="Width" onChange={handleChange} />
                            <input type="text" id="length" name="length" placeholder="Length" onChange={handleChange} />
                            <p className="description">Please, provide dimensions</p>
                        </div>
                    ) : null}
                </form>
            </div>
        </div>
    )
}

export default AddProduct;