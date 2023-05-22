import "../styles/Item.css";

const Item=(props)=> {

    const handleChange=(event)=> {
        const {id, checked} = event.target;
        props.onChange(id, checked);
    }

    return (
        <div className="item">
            <input type="checkbox" id={props.sku} className="delete-checkbox" onChange={handleChange} />
            <p>{props.sku}</p>
            <p>{props.name}</p>
            <p>{props.price}$</p>
            {props.type === "dvd" ? (
                <div className="attributes">
                    <p>Size: {props.size} MB</p>
                </div>
            ) : props.type === "book" ? (
                <div className="attributes">
                    <p>Weight: {props.weight} KG</p>
                </div>
            ) : props.type  === "furniture" ? (
                <div className="attributes">
                    <p>Dimensions: {props.height}x{props.width}x{props.length}</p>
                </div>
            ) : null}
        </div>
    )
}

export default Item;