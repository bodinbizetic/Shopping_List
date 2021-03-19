class ItemTable {
    static instance = null;

    constructor() {
        this.table = document.getElementsByTagName("tbody")[0];
        this.selectedRowIndex = undefined;
    }

    static getInstance() {
        if(ItemTable.instance == null) {
            ItemTable.instance = new ItemTable();
        }   
        return ItemTable.instance;
    }

    setRowIndex(index) {
        this.selectedRowIndex = index;
    }

}

var NUM_ROWS = 3;
var names = ["Hleb", "Mleko", "Secer"];
var quantities = ["2", "2", "200g"];

function onLoad() {
    var table = ItemTable.getInstance();

    for (let i = 0; i < NUM_ROWS; i++) {
        row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
        cellName = row.insertCell(0);
        cellQuantity = row.insertCell(1);
        cellActions = row.insertCell(2);
        cellQuantity.innerHTML = quantities[i];
        cellName.innerHTML = names[i]; // GOBELJA PAGE
        cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" +
            "<a href='./newItem.html' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>" +
            "<a href='#' class='btn btn-outline-danger' onclick='setRowIndex(this)' role='button' aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'>Delete</a>" +
         "</div>";
    }
}

function deleteList() {
    table = ItemTable.getInstance();
    table.table.deleteRow(table.selectedRowIndex);
}