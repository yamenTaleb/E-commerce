import { createContext, useEffect, useState } from "react";
import { products } from "../assets/assets";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import { API_BASE_URL } from "../config";
export const ShopContext = createContext();

const ShopeContextProvider = (props) => {
    const currency = "$";
    const delivery_fee = 10;
    const [search, setSearch] = useState("");
    const [showSearch, setShowSearch] = useState(false);
    const [cartItems, setCartItems] = useState({});
    const navigate = useNavigate();

    const addToCart = async (itemId, size) => {
        if (!size) {
            toast.error("Select Product Size");
            return;
        }

        let cartData = structuredClone(cartItems);
        if (cartData[itemId]) {
            if (cartData[itemId][size]) {
                cartData[itemId][size] += 1;
            } else {
                cartData[itemId][size] = 1;
            }
        } else {
            cartData[itemId] = {};
            cartData[itemId][size] = 1;
        }
        setCartItems(cartData);
    };

    const getCartCount = () => {
        let totalCount = 0;
        for (const items in cartItems) {
            for (const item in cartItems[items]) {
                try {
                    if (cartItems[items][item] > 0) {
                        totalCount += cartItems[items][item];
                    }
                } catch (error) {}
            }
        }
        return totalCount;
    };
    const login = async (email, password) => {
        try {
            const response = await fetch(`${API_BASE_URL}/login`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ email, password }),
            });
            const data = await response.json();
            if (data.status === "success") {
                localStorage.setItem("token", data.data.token);

                toast.success(data.message);
                navigate("/");
            } else {
                toast.error(data.message);
            }
        } catch (error) {
            console.error("Login error:", error);
            toast.error("حدث خطأ أثناء تسجيل الدخول.");
        }
    };

    const register = async (
        name,
        email,
        password,
        password_confirmation,
        phone,
        address
    ) => {
        try {
            const response = await fetch(`${API_BASE_URL}/register`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation,
                    phone,
                    address,
                }),
            });
            const data = await response.json();
            if (data.status === "success") {
                localStorage.setItem("token", data.data.token);

                toast.success(data.message);
                navigate("/");
            } else {
                toast.error(data.message);
            }
        } catch (error) {
            console.error("Register error:", error);
            toast.error("حدث خطأ أثناء التسجيل.");
        }
    };

    const updateQuantity = async (itemId, size, quantity) => {
        let cartData = structuredClone(cartItems);
        if (quantity <= 0) {
            if (cartData[itemId] && cartData[itemId][size]) {
                delete cartData[itemId][size];
                if (Object.keys(cartData[itemId]).length === 0) {
                    delete cartData[itemId];
                }
            }
        } else {
            if (cartData[itemId]) {
                cartData[itemId][size] = quantity;
            } else {
                cartData[itemId] = { [size]: quantity };
            }
        }
        setCartItems(cartData);
    };

    // دالة removeFromCart الجديدة
    const removeFromCart = (itemId, size) => {
        updateQuantity(itemId, size, 0);
    };

    const getCartAmount = () => {
        let totalAmount = 0;
        for (const items in cartItems) {
            let itemInfo = products.find((product) => product._id === items);
            for (const item in cartItems[items]) {
                try {
                    if (cartItems[items][item] > 0) {
                        totalAmount += itemInfo.price * cartItems[items][item];
                    }
                } catch (error) {}
            }
        }
        return totalAmount;
    };

    const value = {
        products,
        currency,
        delivery_fee,
        search,
        setSearch,
        showSearch,
        setShowSearch,
        cartItems,
        addToCart,
        getCartCount,
        updateQuantity,
        removeFromCart,
        getCartAmount,
        navigate,
        login,
        register,
    };

    return (
        <ShopContext.Provider value={value}>
            {props.children}
        </ShopContext.Provider>
    );
};
export default ShopeContextProvider;
