let editContainers = document.querySelectorAll(".edit-container");
let paragraphe = document.querySelectorAll(".value");
let id = document.querySelectorAll(".id");
let buttonEdit = document.querySelectorAll(".edit-button");

///////////////////////// edit
buttonEdit.forEach((button, index) => {
    button.addEventListener("click", function () {
        let idTitre = id[index].value;
        console.log(idTitre);
        let content = `<input value="${paragraphe[index].innerHTML}" class="inputValue">
                            <button class="envoie">valider</button>`;
        paragraphe[index].innerHTML = content;

        buttonEdit.forEach((buttonEdite, index) => {
            buttonEdite.remove();
        });
        recupValider(idTitre);
    });
});

// fonction qui permet la recuperation de la value de l'input et qui fait la requete AJAX
function recupValider(idTitre) {
    let valider = document.querySelectorAll(".envoie");
    let inputValue = document.querySelectorAll(".inputValue");
    valider.forEach((element, index) => {
        element.addEventListener("click", function () {
            let objet = {
                id: idTitre,
                titre: inputValue[index].value,
            };

            console.log(objet, "objet");
            async function requet() {
                const promise = await fetch(
                    "http://127.0.0.1:8000/api/envoie",
                    {
                        method: "POST",
                        body: JSON.stringify(objet),
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );
                console.log(promise);
                if (promise.status === 200) {
                    console.log("c'est good");
                    window.location.reload();
                } else {
                    console.log("c'est pas good");
                }
            }
            requet();
        });
    });
}

/////////// function delete post
let buttonDelete = document.querySelectorAll("#delete");
buttonDelete.forEach((element, index) => {
    element.addEventListener("click", function () {
        // let titre = paragraphe[index].innerHTML;
        let idTitre = id[index].value;
        async function requet() {
            let objet = {
                id: idTitre,
            };
            const promise = await fetch("http://127.0.0.1:8000/api/delete", {
                method: "POST",
                body: JSON.stringify(objet),
                headers: {
                    "Content-Type": "application/json",
                },
            });
            console.log(promise);
            if (promise.status === 200) {
                console.log("c'est good");
                window.location.reload();
            } else {
                console.log("c'est pas good");
            }
        }
        requet();
    });
});

/// Invitation
let invitContainers = document.querySelectorAll(".card");
let buttonInvitation = document.querySelectorAll(".invitation");
console.log(invitContainers, "hey");
buttonInvitation.forEach((button, index) => {
    button.addEventListener("click", function () {
        console.log(button, "testodzadazdaz");
        let div = document.createElement("div");
        let idTitre = id[index].value;
        let contenue = `<input class="email" type="email" placeholder="email"/>
                <button class="valider">valider</button><hr> `;
        div.innerHTML = contenue;
        invitContainers[index].appendChild(div);
        buttonInvitation.forEach((buttonEmail, index) => {
            buttonEmail.remove();
        });
        invitation(idTitre);
    });
});

function invitation(idTitre) {
    let valider = document.querySelectorAll(".valider");
    let inputValue = document.querySelectorAll(".email");
    valider.forEach((element, index) => {
        element.addEventListener("click", function () {
            let objet = {
                id: idTitre,
                email: inputValue[index].value,
            };
            console.log(objet, "objet");
            async function requet() {
                const promise = await fetch("http://127.0.0.1:8000/api/email", {
                    method: "POST",
                    body: JSON.stringify(objet),
                    headers: {
                        "Content-Type": "application/json",
                    },
                });
                console.log(promise);
                if (promise.status === 200) {
                    console.log("c'est good");
                    window.location.reload();
                } else {
                    console.log("c'est pas good");
                }
            }
            requet();
        });
    });
}

// Lien vers la page list avec la recuperation de l'id

let buttonLien = document.querySelectorAll(".buttonLien");

buttonLien.forEach((button, index) => {
    button.addEventListener("click", function () {
        let idProjet = id[index].value;
        window.location.href = `http://127.0.0.1:8000/lists/${idProjet}`;
    });
});

// Lien vers la collaboration

let buttonColaboration = document.querySelectorAll(".lienCollab");
let idTitreCollab = document.querySelectorAll(".idTitreCollab");
buttonColaboration.forEach((button, index) => {
    button.addEventListener("click", function () {
        let idCollab = idTitreCollab[index].value;
        window.location.href = `http://127.0.0.1:8000/lists/${idCollab}`;
    });
});
