import { createContext } from "react";
import { products } from "../assets/assets";
export const ShopeContext = createContext();
const ShopeContextProvider = (props)=> {

    const currency = '$';
    const delivery_fee = 10;


    const value = {
        products,currency,delivery_fee
    }

    return (
        <ShopeContext value={value}>
            {props.children}
        </ShopeContext>
    )

}
export default ShopeContextProvider;
