import React, { createContext, useState, useEffect, useContext } from 'react';

const WishlistContext = createContext();

export const WishlistProvider = ({ children }) => {
  const [wishlistItems, setWishlistItems] = useState(() => {

    const savedWishlist = localStorage.getItem('wishlistItems');
    return savedWishlist ? JSON.parse(savedWishlist) : [];
  });

  useEffect(() => {
    localStorage.setItem('wishlistItems', JSON.stringify(wishlistItems));
  }, [wishlistItems]);

  const addToWishlist = (itemId) => {
    setWishlistItems((prevItems) => {
      if (!prevItems.includes(itemId)) {
        return [...prevItems, itemId];
      }
      return prevItems;
    });
  };

  const removeFromWishlist = (itemId) => {
    setWishlistItems((prevItems) => prevItems.filter((id) => id !== itemId));
  };

  const isItemInWishlist = (itemId) => {
    return wishlistItems.includes(itemId);
  };

  return (
    <WishlistContext.Provider
      value={{ wishlistItems, addToWishlist, removeFromWishlist, isItemInWishlist }}
    >
      {children}
    </WishlistContext.Provider>
  );
};

export const useWishlist = () => useContext(WishlistContext);
