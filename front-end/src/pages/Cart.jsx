import React, { useContext, useEffect, useState } from "react";
import { ShopContext } from "../context/ShopContext";
import Title from "../Components/Title";
import { assets } from "../assets/assets";
import CartTotal from "../context/CartTotal";

const Cart = () => {
    const { products, currency, cartItems, updateQuantity, navigate } =
        useContext(ShopContext);

    const [cartData, seCartData] = useState([]);

    useEffect(() => {
        const tempData = [];
        for (const items in cartItems) {
            for (const item in cartItems[items]) {
                if (cartItems[items][item] > 0) {
                    tempData.push({
                        _id: items,
                        size: item,
                        quantity: cartItems[items][item],
                    });
                }
            }
        }
        seCartData(tempData);
    }, [cartItems]);
    return (
        <div className="border-t pt-5">
            <div className="fs-4 mb-3">
                <Title text1={"YOUR"} text2={"CART"} />
            </div>

            <div>
                {cartData.map((item, index) => {
                    const productData = products.find(
                        (product) => product._id === item._id
                    );
                    return (
                        <div
                            key={index}
                            className="py-3 border-top border-bottom text-secondary product-grid items-center gap-4"
                        >
                            <div className="d-flex align-items-start gap-4">
                                <img
                                    className="w-16 sm-w-20"
                                    src={productData.image[0]}
                                    alt=""
                                />
                                <div>
                                    <p className="custom-text fw-medium">
                                        {productData.name}
                                    </p>
                                    <div className="d-flex align-items-center gap-4 mt-2">
                                        <p>
                                            {currency}
                                            {productData.price}
                                        </p>
                                        <p className="px-2 sm:px-3 sm:py-1 border bg-light">
                                            {item.size}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <input
                                onChange={(e) =>
                                    e.target.value === "" ||
                                    e.target.value === "0"
                                        ? null
                                        : updateQuantity(
                                              item._id,
                                              item.size,
                                              Number(e.target.value)
                                          )
                                }
                                className="border max-w-10 sm-max-w-20 px-1 px-sm-2 py-1"
                                type="number"
                                min={1}
                                defaultValue={item.quantity}
                            />
                            <img
                                onClick={() => {
                                    updateQuantity(item._id, item.size, 0);
                                }}
                                className="w-4 me-4 sm-w-5 pointer bin-icon"
                                src={assets.bin_icon}
                                alt=""
                            />
                        </div>
                    );
                })}
            </div>

            <div className="d-flex justify-content-end my-20">
                <div className="sm-w-450">
                    <CartTotal />
                    <div className="w-100 text-end">
                        <button onClick={()=>navigate('/place-order')} className="bg-black border-0 text-white fs-6 my-5 px-4 py-3 button">
                            PROCEED TO CHECKOUT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Cart;
