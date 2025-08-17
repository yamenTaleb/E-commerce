import React, { useContext, useEffect, useState } from 'react'
import { ShopContext } from '../context/ShopContext'
import { assets } from '../assets/assets';
import { useLocation } from 'react-router-dom';
const SearchBar = () => {

    const {search,setSearch,showSearch,setShowSearch} = useContext(ShopContext);
    const [visible,setVisible] = useState(false);
    const location = useLocation();

    useEffect(()=>{
        if (location.pathname.includes('collection')) {
            setVisible(true);
        }
        else {
            setVisible(false)
        }
    },[location])

  return showSearch && visible ?(
    <div className='border-top border-bottom bg-light text-center'>
        <div className='d-inline-flex align-items-center justify-content-center border custom-border-gray px-3 py-2 my-3 mx-3 rounded-pill custom-w-75 custom-sm-w-50'>
            <input value={search} onChange={(e)=>setSearch(e.target.value)} className='flex-grow-1 no-outline border-0 bg-inherit fs-6 search-icon' type="text" placeholder='Search'/>
            <img className='w-4' src={assets.search_icon} alt="" />
        </div>
        <img onClick={()=>setShowSearch(false)} className='d-inline w-3 pointer' src={assets.cross_icon} alt="" />
    </div>
  ):null
}

export default SearchBar
