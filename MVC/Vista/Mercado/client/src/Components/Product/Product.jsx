import "./Product.css";
import { initMercadoPago, Wallet } from '@mercadopago/sdk-react';
import axios from 'axios';
import { useState } from "react";



const Product = () => {
    const [preferenceId, setPreferenceId] = useState(null);
    // Inicializa Mercado Pago con tu public key
    initMercadoPago('APP_USR-8cf87360-1878-4484-be17-19415e2931e7',
        {
            locale: 'es-CO',
        });

    const createPreference = async () => {
        try {
            const response = await axios.post('http://localhost:3000/create_preference', {
                title: 'Product Name',
                quantity: 1,
                price: 3000,
            });

            const { id } = response.data;
            return id;
        } catch (error) {
            console.error(error);
        }
    };

    const handleBuy = async () => {
        const id = await createPreference();
        if (id) {
        setPreferenceId(id);
        }
    };

    return (

        <div className="Card-Product-Container">
            <div className="Card-Product">
                <div className="Card">
                    <img src="" alt="" />
                    <h3>Product</h3>
                    <p className="price">100 $</p>
                    <button onClick={handleBuy}>Comprar</button>
                    { preferenceId && <Wallet initialization={{ preferenceId: preferenceId }} />}
                </div>
            </div>
        </div>
    )
}

export default Product 