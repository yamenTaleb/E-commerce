import React, { useContext, useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { ShopContext } from "../context/ShopContext";
import { assets } from "../assets/assets";
import RelatedProducts from "../Components/RelatedProducts";
import { useWishlist } from "../context/WishlistContext";

const Product = () => {
    const { productId } = useParams();
    const { products, currency, addToCart } = useContext(ShopContext);
    const { addToWishlist, removeFromWishlist, isItemInWishlist } =
        useWishlist();
    const [productData, setProductData] = useState(false);
    const [image, setImage] = useState("");
    const [size, setSize] = useState("");
    const handleWishlistToggle = () => {
        if (isItemInWishlist(productData._id)) {
            removeFromWishlist(productData._id);
        } else {
            addToWishlist(productData._id);
        }
    };

    const fetchProductData = async () => {
        products.map((item) => {
            if (item._id === productId) {
                setProductData(item);
                setImage(item.image[0]);

                return null;
            }
        });
    };
    useEffect(() => {
        fetchProductData();
    }, [productId]);

    return productData ? (
        <div className="border-top-2 pt-5 transition-opacity-ease-in opacity-100">
            {/*-------- product data------------ */}
            <div className="d-flex gap-5 g-sm-5 flex-column flex-sm-row">
                {/* ---------product images---------- */}
                <div className="flex-grow-1 d-flex flex-column-reverse gap-1 flex-sm-row">
                    <div className="d-flex flex-sm-column overflow-x-auto justify-content-between sm-justify-normal sm-w-18-7 w-100">
                        {productData.image.map((item, index) => (
                            <img
                                onClick={() => setImage(item)}
                                src={item}
                                key={index}
                                className="w-24p sm-w-100 mb-sm-1 h-auto flex-shrink-0 pointer"
                            />
                        ))}
                    </div>
                    <div className="w-100 sm-w-80p">
                        <img className="w-100 h-auto" src={image} alt="" />
                    </div>
                </div>

                {/* ----------product info---------*/}
                <div className="flex-grow-1">
                    <h1 className="fw-medium fs-4 mt-1">{productData.name}</h1>
                    <div className="d-flex align-items-center gap-1 mt-2">
                        <img src={assets.star_icon} alt="" className="w-3 5" />
                        <img src={assets.star_icon} alt="" className="w-3 5" />
                        <img src={assets.star_icon} alt="" className="w-3 5" />
                        <img src={assets.star_icon} alt="" className="w-3 5" />
                        <img
                            src={assets.star_dull_icon}
                            alt=""
                            className="w-3 5"
                        />
                        <p className="ps-2 mb-0">(122)</p>
                    </div>
                    <p className="mt-3 fs-5 fw-medium">
                        {currency}
                        {productData.price}
                    </p>
                    <p className="mt-2 w-4-5 small text-secondary">
                        {productData.description}
                    </p>
                    <div className="d-flex flex-column gap-3 my-4">
                        <p>Select Size</p>
                        <div className="d-flex gap-2">
                            {productData.sizes.map((item, index) => (
                                <button
                                    onClick={() => setSize(item)}
                                    className={`button-size border py-2 px-4  ${
                                        item === size ? "border-orange-500" : ""
                                    }`}
                                    key={index}
                                >
                                    {item}
                                </button>
                            ))}
                        </div>
                    </div>

                    <button
                        onClick={() => addToCart(productData._id, size)}
                        className="button border-0 bg-black text-white px-4 py-3 small bg-gray-700"
                    >
                        ADD TO CART
                    </button>
                    <button
                        onClick={handleWishlistToggle}
                        className="btn btn-outline-danger ms-2"
                    >
                        {isItemInWishlist(productData._id) ? (
                            <i className="bi bi-heart-fill"></i> // أيقونة قلب ممتلئة إذا كان في قائمة الأمنيات
                        ) : (
                            <i className="bi bi-heart"></i> // أيقونة قلب فارغة إذا لم يكن في قائمة الأمنيات
                        )}
                    </button>

                    <hr className="mt-4 col-sm-10" />
                    <div className="small text-secondary mt-5 d-flex flex-column gap-1">
                        <p>100% Original product.</p>
                        <p>Cash on delivery is available on this product.</p>
                        <p>Easy return and exchange policy within 7 days.</p>
                    </div>
                </div>
            </div>
            {/* description & review section */}
            <div className="mt-5">
                <div className="d-flex">
                    <b className="mb-0 border px-5 py-3 small">Description</b>
                    <p className="mb-0 border px-5 py-3 small">Reviews (122)</p>
                </div>
                <div className="d-flex flex-column gap-3 border px-4 py-3 small text-secondary">
                    <p>
                        An e-commerce website is an online platform that
                        facilitates the buying and selling of products or
                        services over the internet. It serves as a virtual
                        marketplace where businesses and individuals can
                        showcase their products, interact with customers, and
                        conduct transactions without the need for a physical
                        presence. E-commerce websites have gained immense
                        popularity due to their convenience, accessibility, and
                        the global reach they offer.
                    </p>
                    <p>
                        E-commerce websites typically display products or
                        services along with detailed descriptions, images,
                        prices, and any available variations (e.g., sizes,
                        colors). Each product usually has its own dedicated page
                        with relevant information.
                    </p>
                </div>
            </div>

            {/* ------display related products------- */}

            <RelatedProducts
                category={productData.category}
                subCategory={productData.subCategory}
            />
        </div>
    ) : (
        <div className="opacity-0"></div>
    );
};

export default Product;
