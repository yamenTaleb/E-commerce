import React, { useContext } from 'react';
import { useWishlist } from '../context/WishlistContext';
import { ShopContext } from '../context/ShopContext';
import { assets } from '../assets/assets';
import { Link } from 'react-router-dom';
import Title from '../Components/Title';

const Wishlist = () => {
  const { wishlistItems, removeFromWishlist } = useWishlist();
  const { products, currency } = useContext(ShopContext);

  const getProductDetails = (productId) => {
    return products.find(product => product._id === productId);
  };

  return (
    <div className="container border-top">
    <div className='text-base fs-3 my-4 text-center '>

      <Title  text1={'MY'} text2={'WISHLIST'}/>
      </div>
     {wishlistItems.length === 0 ? (
        <p className="text-center">Your wishlist is empty.</p>
      ) : (
        <div className="row">
          {wishlistItems.map((itemId) => {
            const product = getProductDetails(itemId);
            if (!product) return null;
            return (
              <div key={itemId} className="col-md-4 mb-4">
                <div className="card h-100">
                  <Link to={`/product/${product._id}`}>
                    <img src={product.image[0]} className="card-img-top" alt={product.name} />
                  </Link>
                  <div className="card-body d-flex flex-column">
                    <h5 className="card-title">{product.name}</h5>
                    <p className="card-text fw-bold">{currency}{product.price}</p>
                    <button
                      onClick={() => removeFromWishlist(itemId)}
                      className="btn btn-danger mt-auto"
                    >
                      Remove from Wishlist
                    </button>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      )}
    </div>
  );
};

export default Wishlist;
