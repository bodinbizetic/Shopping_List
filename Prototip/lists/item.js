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
var cene = ["50din", "200din", "100din"];

function onLoad() {
    var table = ItemTable.getInstance();

    for (let i = 0; i < NUM_ROWS; i++) {
        row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
        cellName = row.insertCell(0);
        cellQuantity = row.insertCell(1);
        cellActions = row.insertCell(2);
        cellPrice = row.insertCell(3);
        cellCheck = row.insertCell(4);
        cellQuantity.innerHTML = quantities[i];
        cellName.innerHTML = names[i]; // GOBELJA PAGE
        cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" +
            "<a href='./editItem.html' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>" +
            "<a href='#' class='btn btn-outline-danger' onclick='setRowIndex(this)' role='button' aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'>Delete</a>" +
         "</div>";
        cellPrice.innerHTML = cene[i];
        cellCheck.innerHTML = "<div><input type=checkbox></input></div>"
    }
    

    row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
    cellName = row.insertCell(0);
    cellQuantity = row.insertCell(1);
    cellActions = row.insertCell(2);
    cellPrice = row.insertCell(3);
    cellCheck = row.insertCell(4);
    cellQuantity.innerHTML = "<b>3</b>";
    cellName.innerHTML = "<b>Total</b>" // GOBELJA PAGE
    cellActions.innerHTML = "";
    cellPrice.innerHTML = "<b>350din</b>";
    cellCheck.innerHTML = ""
}

function deleteList() {
    table = ItemTable.getInstance();
    table.table.deleteRow(table.selectedRowIndex);
}