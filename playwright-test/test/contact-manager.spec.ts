import test from "@playwright/test";
import { ContactPage } from "../pages/ContactPage";



test('add a contact', async ({page}) =>{

    const contact = { id: '', name: 'Luis', email: 'luis@example.com', phone: '12345678' };
    
    const contactPage = new ContactPage(page);

    await contactPage.goto('http://localhost:8000/');
    await contactPage.addContact(contact);

    await contactPage.verifyContactAdded(contact);

});

test('delete a contact', async ({page}) =>{

    const contact1 = { id:'', name: 'Contact1', email: 'lui1s@example.com', phone: '12345678' };
    const contact2 = { id:'', name: 'Contact2', email: 'luis2@example.com', phone: '22345678' };
    const contact3 = { id:'', name: 'Contact3', email: 'luis3@example.com', phone: '32345678' };
    
    const contactPage = new ContactPage(page);

    await contactPage.goto('http://localhost:8000/');
    const id1 = await contactPage.addContact(contact1);
    const id2 = await contactPage.addContact(contact2) ?? '';
    const id3 = await contactPage.addContact(contact3);
    
    console.log('*********1 '+id1);
    console.log('*********2 '+id2);
    console.log('*********3 '+id3);

    //const rowLocator = await contactPage.searchContact(id2);
    await contactPage.deleteContact(id2);

    await contactPage.verifyContactDeleted(id2);
    

});
