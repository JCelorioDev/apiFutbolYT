<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminati\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class JugadorController extends Controller
{
    // Lista de jugadores
    public function index()
    {
        try {
            $jugadores = Jugador::join('equipo', 'jugador.equipo_id', '=', 'equipo.id')->select('jugador.*', 'equipo.id', 'equipo.nombre_equipo', 'equipo.nombre_dt', 'equipo.logo', 'equipo.id as equipo_id')->get();
            return ApiResponse::success('Mostrando lista de jugadores', 200, $jugadores);
        } catch (Exception $e) {
            return ApiResponse::error('Ocurrio un error en la base de datos', 500);
        }
    }


    // Crear jugador
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_jugador' => 'required',
                'n_camisa' => 'required',
                'posicion_jugador' => 'required',
                'equipo_id' => 'required'
            ]);

            Jugador::create($request->all());
            return ApiResponse::success('Se ha creado jugador exitosamente', 201);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion', 401, $errors);
        } catch (Exception $e) {
            return ApiResponse::error('Ocurrio un error en la base de datos', 500);
        }
    }

    // Mostrar un jugador
    public function show($id)
    {
        try {
            $jugador = Jugador::where(['id' => $id])->firstOrFail();
            return ApiResponse::success('Mostrando un jugador', 200, $jugador);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Jugador no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Ocurrio un error en la base de datos', 500);
        }
    }


    // Actualizar jugador
    public function update(Request $request, $id)
    {
        try {
            $jugador = Jugador::where(['id' => $id])->firstOrFail();

            $request->validate([
                'nombre_jugador' => 'required',
                'n_camisa' => 'required',
                'posicion_jugador' => 'required',
                'equipo_id' => 'required'
            ]);

            $jugador->update($request->all());
            return ApiResponse::success('Se ha actualizado correctamente el jugador', 202);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion', 401, $errors);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Jugador no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Ocurrio un error en la base de datos', 500);
        }
    }

    // Eliminar el jugador
    public function destroy($id)
    {
        try {
            $jugador = Jugador::where(['id' => $id])->firstOrFail();
            $jugador->delete();
            return ApiResponse::success('Se ha eliminando correctamente el jugador', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Jugador no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Ocurrio un error en la base de datos', 500);
        }
    }
}
