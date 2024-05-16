function confirmarClique(){
    if (confirm("Tem certeza que deseja excluir esse Produto?")) {
        window.location.href = "excluir_produto.php";

} else {
    return false;
}
}