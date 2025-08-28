import { createContext, useEffect, useState } from "react";
import { products } from "../assets/assets";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";

export const ShopContext = createContext();

const ShopeContextProvider = (props)=> {

    const currency = '$';
    const delivery_fee = 10;
    const [search,setSearch] = useState('');
    const [showSearch,setShowSearch] = useState(false);
    const [cartItems,setCartItems] = useState({});
    const navigate = useNavigate();

    const addToCart = async (itemId,size)=>{

        if (!size) {
            toast.error('Select Product Size');
            return;
        }

        let cartData = structuredClone(cartItems);
        if (cartData[itemId]) {
            if (cartData[itemId][size]) {
                cartData[itemId][size]+=1;
            }
            else {
                cartData[itemId][size]=1;
            }
        }
        else {
            cartData[itemId] = {};
            cartData[itemId][size] = 1;
        }
        setCartItems(cartData);
    }

    const getCartCount = () =>{
        let totalCount = 0;
        for(const items in cartItems) {
            for(const item in cartItems[items]){
                try {
                    if (cartItems[items][item] > 0) {
                        totalCount += cartItems[items][item];
                    }
                } catch (error) {

                }
            }
        }
        return totalCount;
    }

    // دالة تحديث الكمية المعدلة
    const updateQuantity = async(itemId, size, quantity) => {
        let cartData = structuredClone(cartItems);
        if (quantity <= 0) {
            // إذا كانت الكمية صفر أو أقل، احذفي هذا الحجم من المنتج
            if (cartData[itemId] && cartData[itemId][size]) {
                delete cartData[itemId][size];
                // إذا لم يتبق أي أحجام لهذا المنتج، احذفي المنتج نفسه
                if (Object.keys(cartData[itemId]).length === 0) {
                    delete cartData[itemId];
                }
            }
        } else {
            // وإلا، حدثي الكمية
            if (cartData[itemId]) {
                cartData[itemId][size] = quantity;
            } else {
                // هذا السيناريو لا ينبغي أن يحدث إذا كان العنصر موجوداً بالفعل
                // ولكن لضمان السلامة، إذا لم يكن المنتج موجوداً، أنشئيه
                cartData[itemId] = { [size]: quantity };
            }
        }
        setCartItems(cartData);
    }

    // دالة removeFromCart الجديدة
    const removeFromCart = (itemId, size) => {
        updateQuantity(itemId, size, 0); // استخدمي دالة updateQuantity لإزالة العنصر
    }

    const getCartAmount = () => {
        let totalAmount = 0;
        for(const items in cartItems) {
            let itemInfo = products.find((product)=>product._id === items);
            for (const item in cartItems[items]) {
                try {
                    if (cartItems[items][item] > 0) {
                        totalAmount += itemInfo.price * cartItems[items][item]
                    }

                } catch (error) {

                }
            }
        }
        return totalAmount
    }

    const value = {
        products,currency,delivery_fee,
        search,setSearch,showSearch,setShowSearch,
        cartItems,addToCart,
        getCartCount,updateQuantity,removeFromCart, // تأكدي من إضافة removeFromCart هنا
        getCartAmount, navigate
    }

    return (
        <ShopContext.Provider value={value}>
            {props.children}
        </ShopContext.Provider>
    )

}
export default ShopeContextProvider;
