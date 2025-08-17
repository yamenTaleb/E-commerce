import React, { useContext } from "react";
import { ShopContext } from "./ShopContext";
import Title from "../Components/Title";

const CartTotal = () => {
    const { currency, delivery_fee, getCartAmount } = useContext(ShopContext);
    return (
        <div className=" w-100">
            <div className="fs-4">
                <Title text1={"CART"} text2={"TOTALS"} />
            </div>
            <div className="d-flex flex-column gap-2 mt-2 small">
                <div className="d-flex justify-content-between">
                    <p>Subtotal</p>
                    <p>
                        {currency} {getCartAmount()}.00
                    </p>
                </div>
                <hr />
                <div className="d-flex justify-content-between">
                    <p>Shipping Fee</p>
                    <p>{currency} {delivery_fee}.00</p>
                </div>
                <hr />
                <div className="d-flex justify-content-between">
                    <b>Total</b>
                    <b>{currency} {getCartAmount() === 0 ? 0 : getCartAmount() + delivery_fee}.00</b>
                </div>
            </div>
        </div>
    );
};

export default CartTotal;
