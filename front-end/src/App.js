import Wishlist from './pages/Wishlist';
import { useTheme } from './context/ThemeContext';
import {Routes,Route} from 'react-router-dom'
import Home from './pages/Home';
import Collection from './pages/Collection';
import About from './pages/About';
import Contact from './pages/Contact';
import Product from './pages/Product';
import Cart from './pages/Cart';
import Login from './pages/Login';
import PlaceOrder from './pages/PlaceOrder';
import Orders from './pages/Orders';
import Navbar from './Components/Navbar'
import Footer from './Components/Footer';
import SearchBar from './Components/SearchBar';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
function App() {
     const { theme } = useTheme();
  return (
    <div className='px-3 px-sm-4 px-md-5 px-lg-5' data-theme={theme}>
        <ToastContainer />
        <Navbar/>
        <SearchBar/>
        <Routes>
            <Route path='/' element={<Home/>}/>
            <Route path='/collection' element={<Collection/>}/>
            <Route path='/about' element={<About/>}/>
            <Route path='/contact' element={<Contact/>}/>
            <Route path='/product/:productId' element={<Product/>}/>
            <Route path='/cart' element={<Cart/>}/>
            <Route path='/login' element={<Login/>}/>
            <Route path='/place-order' element={<PlaceOrder/>}/>
            <Route path='/orders' element={<Orders/>}/>
            <Route path='/wishlist' element={<Wishlist/>}/>
        </Routes>
        <Footer/>
      {/* <LoginRegister/> */}
    </div>
  );
}

export default App;
