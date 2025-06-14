import express from 'express';
import cors from 'cors';
import { MercadoPagoConfig, Preference } from 'mercadopago';

const client = new MercadoPagoConfig({
  accessToken: "APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952",
});

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.json());

app.post('/create_preference', async (req, res) => {
  try {
    const {
      title, quantity, price,
      nombre, apellido, cedula, correo,
      casoId, categoria
    } = req.body;

    const body = {
      items: [{ title, quantity: Number(quantity), unit_price: Number(price), currency_id: 'COP' }],
      back_urls: {
        success: `http://localhost/Pantry_Amigo/MVC/Vista/HTML/RegDonacion.php?status=approved&nombre=${encodeURIComponent(nombre)}&apellido=${encodeURIComponent(apellido)}&cedula=${encodeURIComponent(cedula)}&correo=${encodeURIComponent(correo)}&monto=${price}&caso=${casoId}&cat=${encodeURIComponent(categoria)}`,
        failure: "http://localhost/Pantry_Amigo/MVC/Vista/HTML/RegDonacion.php?status=failure",
        pending: "http://localhost/Pantry_Amigo/MVC/Vista/HTML/RegDonacion.php?status=pending"
      },
      auto_return: "approved"
    };

    const preference = new Preference(client);
    const response = await preference.create({ body });
    res.json({ id: response.id });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Error al crear la preferencia :(' });
  }
});

app.listen(PORT, () => console.log(`Servidor en http://localhost:${PORT}`));



