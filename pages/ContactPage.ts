import { expect, Locator, Page } from "@playwright/test";

interface Contact {
    id: string;
    name: string;
    email: string;
    phone: string;
  }

export class ContactPage{

    readonly page : Page;
    readonly nameInput : Locator;
    readonly emailInput: Locator;
    readonly phoneInput: Locator;
    readonly addButton: Locator;
    readonly rowsTable: Locator;

    constructor(page : Page){
        this.page = page;
        this.nameInput = page.locator('input[name="name"]');
        this.emailInput = page.locator('input[name="email"]');
        this.phoneInput = page.locator('input[name="phone"]');
        this.addButton = page.getByRole('button',{name:'add'});
        this.rowsTable = page.locator('table tbody tr');
    }

    async goto(url: string){
        await this.page.goto(url, { waitUntil: 'networkidle' });
    }

    async searchLastContact(): Promise<string | null> {
        const rowCount = await this.rowsTable.count();

        const row = this.rowsTable.nth(rowCount-1);
        const idCell = row.locator('td').nth(0); // assuming ID is in first column

        const cellText = await idCell.textContent();
        return cellText;
    }

    async searchContact(id: string): Promise<Locator | null>  {
        const rowCount = await this.rowsTable.count();
        
        for (let i =1; i < rowCount; i++) { // skip header row (index 0)
            const row = this.rowsTable.nth(i);
            const idCell = row.locator('td').nth(0); // assuming ID is in first column
            //const deleteCell = row.locator('td').nth(4);
            
            const cellText = await idCell.textContent();
            if (cellText === id) {
                console.log("********** Lo encontre! " + i + "_ "+ cellText );
                console.log("********** Lo encontre row " + row );
                //await deleteCell.locator('a.delete-btn').click();
                return row; // Found the row
            }
        }
        return null;
    }

    async addContact(contact:Contact) : Promise<string | undefined>{
        
        await this.nameInput.fill(contact.name);
        
        await this.emailInput.fill(contact.email);
        await this.phoneInput.fill(contact.phone);

        await this.addButton.click();

        const id = await this.searchLastContact();
        if(id){
            return id;
        }
    }

    async deleteContact(id: string){
        
        const rowLocator = await this.searchContact(id);
        if(rowLocator){
            const deleteCell = rowLocator.locator('td').nth(4);
            this.page.once('dialog', async dialog => {
                console.log(`Dialog message: ${dialog.message()}`);
                await dialog.accept(); // Clicks "OK"
            });
            await deleteCell.locator('a.delete-btn').click();
        }
    }

    async verifyContactDeleted(expectedId: string){

        const rowLocator =  await this.searchContact(expectedId);
        expect(rowLocator).toBeNull();

    }

    async verifyContactAdded(expectedContact: Contact){
        //const rows = this.page.locator('table tbody tr');
        const firstDataRow = this.rowsTable.nth(1); // skip header

        const nameCell = firstDataRow.locator('td').nth(1); // 0: ID, 1: Name
        const emailCell = firstDataRow.locator('td').nth(2);
        const phoneCell = firstDataRow.locator('td').nth(3);
        // Wait for the cell to be visible
        await expect(nameCell).toBeVisible({ timeout: 5000 });
 
        expect(nameCell).toHaveText(expectedContact.name);
        expect(emailCell).toHaveText(expectedContact.email);
        expect(phoneCell).toHaveText(expectedContact.phone);

    }

}