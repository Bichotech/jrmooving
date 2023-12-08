import type { APIRoute } from "astro";
import { Resend } from "resend";

const resend = new Resend(import.meta.env.RESEND_API_KEY);

export const POST: APIRoute = async ({ params, request }) => { 
    const body = await request.json();

    const { to, bcc, from, subject, html, text } = body;

    if (!to || !from || !subject || !html || !text || !bcc) {
        return new Response(null, {
            status: 400,
            statusText: "No se han proveido los datos correctamente"
        })
    }

    const send = await resend.emails.send({
        from,
        to,
        bcc,
        subject,
        html,
        text
    });

    if (send.data) {
        return new Response(
            JSON.stringify({
                message: send.data
            }),
            {
                status: 200,
                statusText: "OK"
            }
        );
    } else {
        return new Response(
            JSON.stringify({
                message: send.error
            }),
            {
                status: 500,
                statusText: "Error interno de servidor"
            }
        );
    }
}