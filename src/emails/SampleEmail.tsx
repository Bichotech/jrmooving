import {
    Body,
    Button,
    Container,
    Head,
    Hr,
    Html,
    Img,
    Preview,
    Section,
    Text,
  } from '@react-email/components';
  import * as React from 'react';
  
interface SampleEmailProps {
    sName: string;
    sCompany: string;
    sEmail: string;
    sPhone: string;
    sMessage: string;
}
  
export const SampleEmail = ({ sName = 'JR Mooving Logistics', sCompany = '', sEmail = 'no-reply@jrmlogistics.com.mx', sPhone='', sMessage='' }: SampleEmailProps) => (
    <Html>
        <Head />
        <Preview>
        The sales intelligence platform that helps you uncover qualified leads.
        </Preview>
        <Body style={main}>
            <Container style={container}>
                <Img
                    src="http://jrmlogistics.com.mx/assets/images/top_logo.png"
                    width="200"
                    height="64"
                    alt="JR Mooving Logistics"
                    style={logo}
                />
                <Text style={paragraph}>
                    Aviso al equipo de <strong>JR Mooving Logisitics</strong>,
                </Text>
                
                <Text style={paragraph}>
                    {sName} Nos envi&oacute; un correo con la siguiente informaci&oacute;n.
                </Text>

                <Text style={paragraph}>
                    Nombre: <strong>{sName}</strong><br />
                    Compa&ntilde;&iacute;a: <strong>{sCompany !== '' ? sCompany : ' - '}</strong><br />
                    Correo electr&oacute;nico: <strong>{sEmail !== '' ? sEmail : ' - '}</strong><br />
                    Tel&eacute;fono: <strong>{sPhone !== '' ? sPhone : ' - '}</strong><br />
                    Mensaje: <strong>{ sMessage !== '' ? sMessage : ' - ' }</strong><br />
                </Text>

                <Text style={paragraph}>
                Saludos,
                <br />
                El equipo de <strong>BichoTech</strong>
                </Text>
                <Hr style={hr} />
                <Text style={footer}>Hércules No. 124, Estrella Sector Elite 64102, Monterrey, NL, MX.</Text>
            </Container>
        </Body>
    </Html>
);

export default SampleEmail;
  
const main = {
    backgroundColor: '#ffffff',
    fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
};

const container = {
    margin: '0 auto',
    padding: '20px 0 48px',
    maxWidth: '800px'
};

const logo = {
    margin: '0 auto',
};

const paragraph = {
    fontSize: '16px',
    lineHeight: '26px',
};

const btnContainer = {
    textAlign: 'center' as const,
};

const hr = {
    borderColor: '#cccccc',
    margin: '20px 0',
};

const footer = {
    color: '#8898aa',
    fontSize: '12px',
};
  