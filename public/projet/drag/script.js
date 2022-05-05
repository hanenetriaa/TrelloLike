const items = document.querySelectorAll(".item");
const columns = document.querySelectorAll(".column");
let dragItem = null;

items.forEach((item) => {
    item.addEventListener("dragstart", dragStart);
    item.addEventListener("dragend", dragEnd);
});

columns.forEach((column) => {
    column.addEventListener("dragover", dragOver);
    column.addEventListener("drop", dragDrop);
});

function dragOver(e) {
    e.preventDefault();
}

function dragStart(e) {
    console.log("drag started");
    setTimeout(() => (this.className = "invisible"), 0);
    console.log(e.target.dataset);
    dragItem = e.target;
    e.dataTransfer.setData("id", e.target.dataset.id);
}

function dragEnd(e) {
    console.log("drag ended");
    this.className = "item";
    dragItem = null;
}

function dragDrop(e) {
    console.log("drag dropped");
    this.append(dragItem);
    let listId = this.dataset.listId;
    let id = e.dataTransfer.getData("id");

    sendMoveTaskRequest(id, listId);
}

async function sendMoveTaskRequest(id, listId) {
    try {
        const response = await fetch("/api/tasks/move", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                id,
                list_id: listId,
            }),
        });

        if (response.status != 200) {
            throw new Error();
        }
    } catch (e) {
        console.log(e);
    }
}
