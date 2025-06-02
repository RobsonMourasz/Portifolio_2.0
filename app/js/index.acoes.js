(() => {
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById("sobre").classList.remove("d-none")
        document.getElementById("Titulo").innerText = "Sobre Mim";
        setTimeout(() => {
            document.getElementById("carregando").classList.remove("carregando");
        }), 1000;

    });

    document.querySelectorAll("a").forEach((link) => {

        link.addEventListener("click", (event) => {
            event.preventDefault();

            document.querySelectorAll("a").forEach((link) => {

                if (link.getAttribute("targ") == "menu") {
                    document.querySelector(link.getAttribute("href")).classList.add("d-none");
                    link.classList.remove("link-active");

                }
            });

            link.classList.add("link-active");
            const target = link.getAttribute("href").replace("#", "");

            if (target) {
                console.log("Target: ", target);
                if (target === "sobre") {
                    document.getElementById("Titulo").innerText = "Sobre Mim";
                }
                else if (target === "habilidades") {
                    document.getElementById("Titulo").innerText = "Minhas Habilidades";
                }
                else if (target === "projetos") {
                    document.getElementById("Titulo").innerText = "Meus Projetos";
                }
                else if (target === "contato") {
                    document.getElementById("Titulo").innerText = "Entre em contato";
                }

                document.getElementById(target).classList.remove("d-none");
            }

        });
    });

})()