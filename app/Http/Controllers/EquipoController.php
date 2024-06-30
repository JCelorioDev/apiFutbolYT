<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Http\Responses\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Exception;

class EquipoController extends Controller
{
    // Lista de equipos

    public function index()
    {
        try {
            $equipos = Equipo::all();
            return ApiResponse::success('Lista de equipos', 200, $equipos);
        } catch (Exception $e) {
            return ApiResponse::error('Error de la base de datos', 500);
        }
    }

    // Guardar un equipo

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_equipo' => 'required|unique:equipo',
                'nombre_dt' => 'required',
                'logo' => 'required|file|mimes:png,jpg, jpeg'
            ],
            [
                'nombre_equipo.required' => 'El nombre de equipo es requerido',
                'nombre_equipo.unique' => 'El nombre de equipo ya esta en uso.',
                'nombre_dt.required' => 'El nombre de director es requerido',
                'logo.required' => 'El logo es requerido'
            ]
            );

            $f = $request->file('logo');

            $nombre = time() . "." . $f->getClientOriginalExtension();

            $f->move(public_path('logos'), $nombre);

            Equipo::create([
                'nombre_equipo' => $request->nombre_equipo,
                'nombre_dt' => $request->nombre_dt,
                'logo' => $nombre
            ]);

            return ApiResponse::success('El equipo se creo correctamente', 201);

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion', 401, $errors);
        } catch (Exception $e){
            return ApiResponse::error('Error en la base de datos', 500);
        }
    }

    // Mostrar un equipo

    public function show($id)
    {
        try {
            $equipo = Equipo::where(['id' => $id])->firstOrFail();
            return ApiResponse::success('Mostrando un equipo', 200, $equipo);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo no encontrado', 404);
        } catch (Exception $e){
            return ApiResponse::error('Error en la base de datos', 500);
        }
    }


    // Actualizar un equipo
    
    public function update(Request $request, $id)
    {
        try {
            $equipo = Equipo::where(['id' => $id])->firstOrFail();

            $nombre = $equipo->logo;

            $request->validate([
                'nombre_equipo' => ['required', Rule::unique('equipo')->ignore($equipo)],
                'nombre_dt' => 'required',
                'logo' => 'required|file|mimes:png,jpg, jpeg'
            ],
            [
                'nombre_equipo.required' => 'El nombre de equipo es requerido',
                'nombre_equipo.unique' => 'El nombre de equipo ya esta en uso.',
                'nombre_dt.required' => 'El nombre de director es requerido',
                'logo.required' => 'El logo es requerido'
            ]);

            if ($nombre) {
                @unlink(public_path("logos")."/".$nombre);
            }

            $f = $request->file('logo');

            $nombre = time() . "." . $f->getClientOriginalExtension();

            $f->move(public_path("logos"), $nombre);

            $equipo->nombre_equipo = $request->nombre_equipo;
            $equipo->nombre_dt = $request->nombre_dt;
            $equipo->logo = $nombre;
            $equipo->update();


            return ApiResponse::success('El equipo se actualizo correctamente', 202);

        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo no encontrado', 404);
        } catch (ValidationException $e){
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion', 401, $errors);
        } catch (Exception $e){
            return ApiResponse::error('Error en la base de datos', 500);
        }
    }

    // Eliminar un equipo

    public function destroy($id)
    {
        try {
            $equipo = Equipo::where(['id' => $id])->firstOrFail();
            $equipo->delete();

            return ApiResponse::success('Equipo eliminado', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo no encontrado', 404);
        } catch (Exception $e){
            return ApiResponse::error('Error en la base de datos', 500);
        }
    }

    public function jugadores_equipo($idEquipo){
        try {
            $je = Equipo::with('jugadores')->findOrFail($idEquipo);
            return ApiResponse::success('Mostrando jugadores por equipo', 200, $je);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo no encontrado', 404);
        } catch (Exception $e){
            return ApiResponse::error('Error en la base de datos', 500);
        }
    }
}
