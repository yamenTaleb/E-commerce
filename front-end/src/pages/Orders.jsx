import React, { useContext } from "react";
import { ShopContext } from "../context/ShopContext";
import Title from "../Components/Title";

const Orders = () => {
    const { products, currency } = useContext(ShopContext);
    return (
        <div className="border-top pt-5">
            <div className="fs-4">
                <Title text1={"MY"} text2={"ORDERS"} />
            </div>

            <div>
                {products.slice(1, 4).map((item, index) => (
                    <div
                        key={index}
                        className="py-3 border-top border-bottom text-secondary d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3"
                    >
                        <div className="d-flex align-items-start gap-5 small">
                            <img
                                className="w-16 sm-w-20"
                                src={item.image[0]}
                                alt=""
                            />
                            <div>
                                <p className="fs-sm-6 font-medium">
                                    {item.name}
                                </p>
                                <div className="d-flex align-items-center gap-3 mt-2 fs-6 text-secondary">
                                    <p className="fs-5">
                                        {currency}
                                        {item.price}
                                    </p>
                                    <p>Quantity: 1</p>
                                    <p>Size: M</p>
                                </div>
                                <p className="mt-2">
                                    Date:{" "}
                                    <span className="text-secondary">
                                        25, Jul, 2025
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div className="d-flex justify-content-between md-w-50">
                            <div className="d-flex align-items-center gap-3">
                                <p className="min-w-2 h-2 rounded-circle bg-success"></p>
                                <p className="small fs-md-6">Ready to ship</p>
                            </div>
                            <button className="button text-dark border bg-light px-3 py-2 small font-medium rounded">Track Order</button>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Orders;
