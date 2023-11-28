import type { APIRoute } from 'astro';
import { Resend } from 'resend';

const resend = new Resend('re_6sfS9ZnR_ArTsGLDWGP4nGH2j8wyjHvD1');

export const post: (APIRoute) => Promise<void> = async ({ request }) => {
    console.log('+++ request', request);
    console.log('Lo que sea!!');
  
    if (request.headers.get('Content-Type') === 'application/json') {
        const formData = await request.json();
        const name = formData.name;
        const company = formData.company;
        const email = formData.email;
        const tel = formData.phone;
        const subject = 'Mensaje enviado desde el sitio';
        const message = `${formData.message};
      ----------------------------------------------------------------------
      De: ${name} • email: ${email} • tel: ${tel} • empresa: ${company}
      `;
        console.log(formData);
        resend.emails.send({
            from: 'no-reply@jrmooving.com.mx',
            to: 'fidel.hdz@me.com',
            subject: subject,
            html: message
        });
    };
};
