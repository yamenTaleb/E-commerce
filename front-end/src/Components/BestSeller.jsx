import React, { useContext, useEffect, useState } from 'react'
import { ShopContext } from '../context/ShopContext';
import ProductItem from './ProductItem';
import Title from './Title';

const BestSeller = () => {
    const {products} = useContext(ShopContext);
    const [bestSeller, setBestSeller] = useState([]);

    useEffect(()=>{
        const bestProduct = products.filter((item)=>(item.bestseller));
        setBestSeller(bestProduct.slice(0,5));
    },[])

  return (
    <div className='my-4'>
        <div className="text-center py-1 fs-3">
            <Title text1={'BEST'} text2={'SELLERS'}/>
            <p style={{fontSize:'12px'}} className='w-75 m-auto fs-sm-6 fs-md-5 text-secondary'>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate dolorem veniam, saepe modi, magni voluptas at sit quasi quas blanditiis possimus reprehenderit est ipsum consequatur dolores ab doloribus quidem illum.
            </p>
        </div>

        <div className='row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 gy-5 mt-1'>
            {
                bestSeller.map((item,index)=>(
                    <ProductItem key={index} id={item._id} name={item.name} image={item.image} price={item.price} />
                ))
            }
        </div>
    </div>
  )
}

export default BestSeller
