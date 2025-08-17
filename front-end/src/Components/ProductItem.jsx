import React, { useContext } from 'react'
import { ShopContext } from '../context/ShopContext'
import {Link} from 'react-router-dom';

const ProductItem = ({id,image,name,price}) => {
    const {currency} = useContext(ShopContext);

  return (
    <Link style={{fontSize:'10px'}} className='text-secondary pointer text-decoration-none' to={`/product/${id}`}>
        <div className='overflow-hidden'>
            <img className='img-fluid img-scale' src={image[0]} alt="" />
        </div>
        <p className='pt-2 pb-1 mb-0'>{name}</p>
        <p className='fw-bold'>{currency}{price}</p>
    </Link>
  )
}

export default ProductItem

