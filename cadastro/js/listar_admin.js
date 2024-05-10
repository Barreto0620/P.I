function confirmarClique(){
    if (confirm("Tem certeza que deseja excluir esse Administrador?")) {
        window.location.href = "excluir_admin.php";

} else {
    return false;
}
}