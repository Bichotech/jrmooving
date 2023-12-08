import React from 'react'
import SampleEmail from '../emails/SampleEmail'
import { render } from '@react-email/render';

const EmailForm = () => {
    const [flag, setFlag] = React.useState(false);
    const [statusText, setStatusText] = React.useState('');

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        
        const formData = new FormData(e.currentTarget);
        const { name, company, email, phone, message, controlEl, avisoCheck } = Object.fromEntries(formData);

        console.log({ name, company, email, phone, message, controlEl, avisoCheck });

        // Validaciones
        if (controlEl !== '') { setStatusText('Error interno en servidor, favor de intentar más tarde.'); return false; }
        if (name === '') { setStatusText('• Su nombre es requerido.'); return false; }
        if (company === '') { setStatusText('• El nombre de su compañía es requerido.'); return false; }
        if (email === '') {
            if (phone === '') {
                setStatusText('• Al menos debe existir uno de los siguientes datos: número de teléfono o un correo electrónico.');
                return false;
            }
        }
        if (avisoCheck !== 'on') { setStatusText('• Señale que acepta haber leído nuestro aviso de privacidad.'); return false; }

        setStatusText('');

        const finalHTML = render(<SampleEmail sName={name as string} sCompany={company as string} sEmail={email as string} sPhone={phone as string} sMessage={message as string} />, { pretty: true });
        const finalText = render(<SampleEmail sName={name as string} sCompany={company as string} sEmail={email as string} sPhone={phone as string} sMessage={message as string} />, { plainText: true });

        if (controlEl !== '') {
            return false;
        }

        try {
            const res = await fetch("/api/sendmail.json", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    from: 'no-reply@jrmlogistics.com.mx',
                    to: ['contacto@jrmlogistics.com.mx', 'framos@jrmlogistics.com.mx'],
                    bcc: 'fh@bicho.tech',
                    subject: `Mensaje enviado desde nuestro portal de parte de ${name}`,
                    html: finalHTML,
                    text: finalText
                })
            });
            const data = await res.json();
            console.log(data.message.id);
            if (data.message.id) {
                setStatusText('Mensaje enviado exitosamente, gracias.');
                document.querySelector('form').reset();
            }
        } catch (e) {
            setStatusText('Error interno en servidor, favor de intentar más tarde.');
            console.error(e);
        }
    };

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label">Nombre</label>
                    <input style={inputCtrl} type="text" name="name" className="form-control" id="inputName" />
                </div>
                <div className="mb-3">
                    <label className="form-label">Empresa</label>
                    <input style={inputCtrl} type="text" name="company" className="form-control" id="input" />
                </div>
                <div className="mb-3">
                    <label className="form-label">Correo Electrónico</label>
                    <input style={inputCtrl} type="email" name="email" className="form-control" id="input" />
                </div>
                <div className="mb-3">
                    <label className="form-label">Teléfono</label>
                    <input style={inputCtrl} type="tel" name="phone" className="form-control" id="inputPhone" />
                </div>
                <div className="mb-3">
                    <label className="form-label">Mensaje</label>
                    <textarea style={inputCtrl} className="form-control" name="message" id="inputMessage"></textarea>
                </div>
                <input type="hidden" aria-hidden id="inputHide" name="controlEl" />
                <div className="mb-3 form-check">
                    <input type="checkbox" className="form-check-input" name="avisoCheck" id="avisoCheck" />
                    <label style={labelSt} className="form-check-label">He leído el <a style={linkSt} href="./aviso-de-privacidad-clientes">aviso de privacidad</a> y acepto enviar mi información.</label>
                </div>
                
                <div className="warnings mt-5">{statusText}</div>
                <button type="submit" style={buttonSt} id="theButton" className="btn btn-primary"><i className="fa-solid fa-paper-plane"></i> Enviar</button>
            </form>
        </div>
    )
}

export default EmailForm

const inputCtrl = {
    fontSize: "1.2rem",
    borderRadius: "unset",
    backgroundColor: "transparent",
    borderColor: "#20354B",
    color: "white",
    fontFamily: "Sarpanch, sans-serif"
}

const buttonSt = {
    borderRadius: "unset",
    padding: "0.5rem 2rem",
    marginTop: "1rem"
}

const labelSt = {
    fontFamily: "Sarpanch, sans-serif"
}

const linkSt = {
    color: "#01ADEE",
    fontFamily: "Sarpanch, sans-serif",
    textDecoration: "none"
}