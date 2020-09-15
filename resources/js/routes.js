import Home from "./components/Home";
import Favorites from "./components/Favorites";
import Register from "./components/Register";
import SignIn from "./components/SignIn";
import ConversionForm from "./components/ConversionForm";

const routes = [
    { path: '/', component: Home},
    { path: '/favorites', component: Favorites },
    { path: '/favorites/:id', component: ConversionForm },
    { path: '/login', component: SignIn },
    { path: '/register', component: Register },
]

export default routes;
