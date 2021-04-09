class ShopTable {
    static instance = null;

    constructor() {
        this.table = document.getElementsByTagName("tbody")[0];
        this.selectedRowIndex = undefined;
    }

    static getInstance() {
        if(ShopTable.instance == null) {
            ShopTable.instance = new ShopTable();
        }   
        return ShopTable.instance;
    }

    setRowIndex(index) {
        this.selectedRowIndex = index;
    }

}

var NUM_ROWS = 3;
var names = ["Hleb", "Mleko", "Secer"];
var quantities = ["2", "2", "200g"];

function onLoad() {
    var table = ShopTable.getInstance();

    for (let i = 0; i < NUM_ROWS; i++) {
        row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
        cellName = row.insertCell(0);
        cellQuantity = row.insertCell(1);
        cellActions = row.insertCell(2);
        cellQuantity.innerHTML = quantities[i];
        cellName.innerHTML = names[i]; // GOBELJA PAGE
        cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" +
            "<input type='checkbox' id='item" + i + "'" +
         "</div>";
    }
}

function deleteList() {
    table = ShopTable.getInstance();
    table.table.deleteRow(table.selectedRowIndex);
}