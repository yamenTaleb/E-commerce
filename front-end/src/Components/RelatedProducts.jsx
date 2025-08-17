import React, { useContext, useEffect, useState } from "react";
import { ShopContext } from "../context/ShopContext";
import Title from "./Title.jsx";
import ProductItem from "./ProductItem";
const RelatedProducts = ({ category, subCategory }) => {
    const { products } = useContext(ShopContext);
    const [related, setRelated] = useState([]);

    useEffect(() => {
        if (products.length > 0) {
            let productsCopy = products.slice();

            productsCopy = productsCopy.filter(
                (item) => category === item.category
            );
            productsCopy = productsCopy.filter(
                (item) => subCategory === item.subCategory
            );
            setRelated(productsCopy.slice(0, 5));
        }
    }, [products]);
    return (
        <div className="my-5">
            <div className="text-center fs-2 py-2 ">
                <Title text1={"RELATED"} text2={"PRODUCTS"} />
            </div>
            <div className="row g-4">
                {related.map((item, index) => (
                    <div key={index} className="col-6 col-sm-4 col-md-3 col-lg-2">
                        <ProductItem
                            id={item._id}
                            name={item.name}
                            price={item.price}
                            image={item.image}
                        />
                    </div>
                ))}
            </div>
        </div>
    );
};

export default RelatedProducts;
