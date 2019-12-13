<?php

$router->get('cliente','ClienteController@home');
$router->post('cliente/criar','ClienteController@criar');
$router->post('cliente/alterar','ClienteController@alterar');
$router->post('cliente/excluir','ClienteController@excluir');
$router->post('cliente/listar','ClienteController@listar');

$router->get('produto','ProdutoController@home');
$router->post('produto/criar','ProdutoController@criar');
$router->post('produto/alterar','ProdutoController@alterar');
$router->post('produto/excluir','ProdutoController@excluir');
$router->post('produto/listar','ProdutoController@listar');

$router->get('compra','CompraController@home');
$router->post('compra/criar','CompraController@criar');
$router->post('compra/alterar','CompraController@alterar');
$router->post('compra/excluir','CompraController@excluir');
$router->post('compra/listar','CompraController@listar');

$router->get('loja','CompraController@loja');
$router->post('loja/compra/criar','CompraController@criarCompra');
$router->post('loja/listar','CompraController@listarTodasLoja');

$router->get('', 'UsuarioController@home');
$router->post('login', 'UsuarioController@login');
$router->post('logout', 'UsuarioController@logout');
