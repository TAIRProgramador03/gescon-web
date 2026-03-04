const odbc = require("odbc");
const jwt = require("jsonwebtoken");
const {dbConfig} = require("../../shared/conf.js");

const login = async (req, res) => {
  // Obtenemos los valores del login desde el cuerpo de la solicitud
  const { dbUser, password } = req.body;

  let connection;

  try {
    // Conexión a DB2 con los valores del login
    connection = await odbc.connect(
      `DSN=${dbConfig.DSN};UID=${dbUser};PWD=${password};System=${dbConfig.system};charset=utf8`,
    );

    // Si la conexión es exitosa, generamos un token JWT con los datos del usuario
    const payload = { globalDbUser: dbUser, globalPassword: password };
    const token = jwt.sign(
      payload,
      process.env.SECRET_KEY || "3c0FNs1Md90ueIaYmaAZAC75TM1MD77l2JeffvxQY6w",
      { expiresIn: "3h", algorithm: "HS256" },
    );

    // Configura la cookie con el token JWT
    res.cookie("access_token", token, {
      httpOnly: true,
      secure: false,
      sameSite: "strict",
      path: "/",
      maxAge: 3 * 60 * 60 * 1000,
    });
    res.json({ success: true, message: "Conexión exitosa" });
  } catch (error) {
    console.error("Error de conexión:", error);
    res.json({ success: false, message: "Error de conexión" });
  } finally {
    if (connection) {
      await connection.close();
    }
  }
};

const logout = async (_req, res) => {
  // Limpiamos la cookie eliminando el token JWT
  res.clearCookie("access_token", {
    httpOnly: true,
    secure: true,
    sameSite: "none",
    path: "/",
  });
  res.json({ success: true, message: "Cierre de sesión exitoso" });
};

const verify = async (req, res) => {
  const token = req.cookies.access_token;

  if (!token) return res.status(401).send("No hay token");

  jwt.verify(
    token,
    process.env.SECRET_KEY || "3c0FNs1Md90ueIaYmaAZAC75TM1MD77l2JeffvxQY6w",
    (err, user) => {
      if (err) return res.status(403).send("Token inválido");
      res.status(200).json({ success: true, message: "Token válido", globalDbUser: user.globalDbUser });
    },
  );
};

module.exports = {
  login,
  logout,
  verify,
};
