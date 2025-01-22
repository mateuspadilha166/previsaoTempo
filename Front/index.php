<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Consulta de Previsão do Tempo</h1>
        </header>

        <!-- consulta-->
        <section class="consulta">
            <form id="form-previsao" method="POST">
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" required>
                </div>
                <div class="form-group">
                    <label for="uf">Estado:</label>
                    <input type="text" name="uf" id="uf" required>
                </div>
                <button type="button" id="btn-consultar">Consultar</button>
            </form>
        </section>

        <!-- Exibição das previsões -->
        <section class="resultados" id="resultados">
            <!--As previsões seram exibidas abaixo-->
        </section>
    </div>

    <script>
    document.getElementById("btn-consultar").addEventListener("click", function () {
        const cidade = document.getElementById("cidade").value.trim();
        const uf = document.getElementById("uf").value.trim();

        if (!cidade || !uf) {
            alert("Informe a cidade e o estado.");
            return;
        }

        fetch("processaPrevisao.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                cidade: cidade,
                uf: uf,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    document.getElementById("resultados").innerHTML = data.message;
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error("Erro na chamada da API:", error);
                alert("Tente novamente.");
            });
    });
</script>
</body>
</html>
