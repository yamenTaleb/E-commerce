import React, { useContext, useState } from "react";
import { assets } from "../assets/assets";
import { Link, NavLink } from "react-router-dom";
import { ShopContext } from "../context/ShopContext";
import { useTheme } from "../context/ThemeContext";

const Navbar = () => {
    const [visible, setVisible] = useState(false);

    const { setShowSearch, getCartCount } = useContext(ShopContext);
    const { theme, toggleTheme } = useTheme();
    return (
        <div className="d-flex justify-content-between align-items-center fw-semibold py-3">
            <Link to={"/"}>
                <img
                    className="logo-icon"
                    src={assets.logo}
                    alt=""
                    style={{ width: "100px" }}
                />
            </Link>

            <ul className="d-none d-sm-flex gap-3 small align-items-center mb-0">
                <NavLink
                    to={"/"}
                    className={
                        "d-flex flex-column align-items-center gap-1 text-secondary text-decoration-none"
                    }
                >
                    <p className="mb-0 fs-11">HOME</p>
                    <hr className="w-50 mt-0 mb-0 border-0 bg-secondary" />
                </NavLink>

                <NavLink
                    to={"/collection"}
                    className={
                        "d-flex flex-column align-items-center gap-1 text-secondary text-decoration-none"
                    }
                >
                    <p className="mb-0 fs-11">COLLECTION</p>
                    <hr className="w-50 mt-0 mb-0 border-0 bg-secondary " />
                </NavLink>

                <NavLink
                    to={"/wishlist"}
                    className={
                        "d-flex flex-column align-items-center gap-1 text-secondary text-decoration-none"
                    }
                >
                    <p className="mb-0 fs-11">WISHLIST</p>
                    <hr className="w-50 mt-0 mb-0 border-0 bg-secondary" />
                </NavLink>

                <NavLink
                    to={"/about"}
                    className={
                        "d-flex flex-column align-items-center gap-1 text-secondary text-decoration-none "
                    }
                >
                    <p className="mb-0 fs-11">ABOUT</p>
                    <hr className="w-50 mt-0 mb-0 border-0 bg-secondary" />
                </NavLink>

                <NavLink
                    to={"/contact"}
                    className={
                        "d-flex flex-column align-items-center gap-1 text-secondary text-decoration-none"
                    }
                >
                    <p className="mb-0 fs-11">CONTACT</p>
                    <hr className="w-50 mt-0 mb-0 border-0 bg-secondary hr-active" />
                </NavLink>
            </ul>

            <div className="d-flex align-items-center gap-4">
                <img
                    onClick={() => setShowSearch(true)}
                    src={assets.search_icon}
                    className="pointer w-4 search-icon"
                    alt=""
                />
                <div className="group position-relative">
                    <Link to="/login">
                        <img
                            src={assets.profile_icon}
                            className="w-4 pointer profile-icon"
                            alt=""
                        />
                    </Link>
                    <div className="d-none position-absolute dropdown-menu end-0  p-0 w-36 bg-light">
                        <div className="d-flex flex-column gap-2 py-3 px-2 m-0 w-36 rounded fs-10">
                            <p className="pointer text-secondary black-hover m-0 text-center">
                                My Profile
                            </p>
                            <p className="pointer text-secondary black-hover m-0 text-center">
                                Orders
                            </p>
                            <p className="pointer text-secondary black-hover m-0 text-center">
                                Logout
                            </p>
                        </div>
                    </div>
                </div>
                <Link to="/cart" className="position-relative">
                    <img
                        src={assets.cart_icon}
                        className="w-4 cart-icon"
                        alt=""
                    />
                    <p className="position-absolute custom-offset lh-md bg-black text-white text-center w-3 h-3 fs-8 rounded-circle cart-count">
                        {getCartCount()}
                    </p>
                </Link>
                <img
                    onClick={() => setVisible(true)}
                    src={assets.menu_icon}
                    className="w-4 pointer d-sm-none "
                    alt=""
                />
                <div className="form-check form-switch d-flex align-items-center mt-1">
                    <input
                        className="form-check-input "
                        type="checkbox"
                        id="darkModeToggle"
                        checked={theme === "dark"}
                        onChange={toggleTheme}
                    />
                    <label
                        className="form-check-label"
                        htmlFor="darkModeToggle"
                    ></label>
                </div>
            </div>

            {/* sidebar menu for small screens */}
            <div
                className={`position-absolute top-0 end-0 bottom-0 overflow-hidden bg-white transition-all `}
                style={{ width: visible ? "100%" : "0px" }}
            >
                <div className="d-flex flex-column text-secondary">
                    <div
                        onClick={() => setVisible(false)}
                        className="d-flex align-items-center gap-3 p-3 pointer"
                    >
                        <img
                            src={assets.dropdown_icon}
                            className="h-4"
                            style={{ transform: "rotate(180deg)" }}
                            alt=""
                        />
                        <p className="mb-0">Back</p>
                    </div>
                    <NavLink
                        onClick={() => setVisible(false)}
                        className={
                            "text-decoration-none text-secondary py-2 ps-3 border"
                        }
                        to="/"
                    >
                        HOME
                    </NavLink>
                    <NavLink
                        onClick={() => setVisible(false)}
                        className={
                            "text-decoration-none text-secondary py-2 ps-3 border"
                        }
                        to="/collection"
                    >
                        COLLECTION
                    </NavLink>
                    <NavLink
                        onClick={() => setVisible(false)}
                        className={
                            "text-decoration-none text-secondary py-2 ps-3 border"
                        }
                        to="/contact"
                    >
                        CONTACT
                    </NavLink>
                    <NavLink
                        onClick={() => setVisible(false)}
                        className={
                            "text-decoration-none text-secondary py-2 ps-3 border"
                        }
                        to="/about"
                    >
                        ABOUT
                    </NavLink>
                </div>
            </div>
        </div>
    );
};

export default Navbar;
