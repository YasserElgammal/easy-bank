<?php

namespace App\Interfaces;


interface BaseRepositoryInterface
{
    public function index();
    public function show(int $id);
    public function store(array $request);
    public function update($id, array $request);
    public function destroy($id);
}
