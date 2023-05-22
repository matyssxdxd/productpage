import { Link, useNavigate } from "react-router-dom";
import { useState } from "react";
import axios from "axios";
import "../styles/AddProduct.css";

const AddProduct=()=> {

    const navigate = useNavigate();

    const options = [
        {value: "", text:"Select product type"},
        {value: "dvd", text:"DVD"},
        {value: "book", text:"Book"},
        {value: "furniture", text:"Furniture"},
    ];

    const [selected, setSelected] = useState(options[0].value);
    const [inputs, setInputs] = useState({});
    const [error, setError] = useState();

    const handleChange =(event)=> {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }

    const handleSelected=(event)=> {
        setSelected(event.target.value);
    }

    const handleType=(event)=>{
        handleSelected(event);
        handleChange(event);
    }

    const handleSubmit=(event)=> {
        event.preventDefault();
        axios.post("https://product-page.x10.mx/api/product/save", inputs)
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
                            SAVE
                        </button>
                        <Link to="/">
                            <button>
                                CANCEL
                            </button>
                        </Link>
                    </div>
                </div>
            </div>
            <div className="form-container">
                <form id="product_form" className="product-form" onSubmit={handleSubmit}>
                    {error !== "" ? (
                        <div className="error-message">{error}</div>
                    ) : null}
                    <input type="text" id="sku" name="sku" placeholder="SKU" onChange={handleChange} />
                    <input type="text" id="name" name="name" placeholder="Name" onChange={handleChange} />
                    <input type="text" id="price" name="price" placeholder="Price" onChange={handleChange} />
                    <select value={selected} name="type" onChange={handleType}>
                        {options.map(option => (
                            <option key={option.value} value={option.value}>
                                {option.text}
                            </option>
                        ))}
                    </select>
                    {selected === "dvd" ? (
                        <div className="selected">
                            <input type="text" id="size" name="size" placeholder="Size" onChange={handleChange} />
                            <p className="description">Please, provide size</p>
                        </div>
                        ) : selected  === "book" ? (
                        <div className="selected">
                            <input type="text" id="weight" name="weight" placeholder="Weight" onChange={handleChange} />
                            <p className="description">Please, provide weight</p>
                        </div>
                        ) : selected  === "furniture" ? (
                        <div className="selected">
                            <input type="text" id="height" name="height" placeholder="Height" onChange={handleChange} />
                            <input type="text" id="width" name="width" placeholder="Width" onChange={handleChange} />
                            <input type="text" id="lenght" name="length" placeholder="Length" onChange={handleChange} />
                            <p className="description">Please, provide dimensions</p>
                        </div>
                    ) : null}
                </form>
            </div>
        </div>
    )
}

export default AddProduct;