<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 1. TU FUNCIÓN DE REGISTRO (Esta ya la tenías bien)
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $idPersona = DB::table('personas')->insertGetId([
                'nombres' => $request->nombre,
                'primer_apellido' => $request->apellido,
                'email' => $request->correo,
                'CI' => 0,
                'genero' => 'N/A',
                'direccion' => 'Sin direccion',
                'fecha_nacimiento' => '2000-01-01',
            ]);
            DB::table('usuarios')->insert([
                'id_persona' => $idPersona,
                'usuario' => $request->usuario,
                'contrasena' => $request->contrasena,
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Registrado correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 2. LA FUNCIÓN DE LOGIN QUE TE FALTABA
    public function login(Request $request)
    {
        $user = DB::table('usuarios')
            ->where('usuario', $request->usuario)
            ->where('contrasena', $request->contrasena)
            ->first();

        if ($user) {
            return response()->json(['success' => true, 'usuario' => $user->usuario], 200);
        }
        
        return response()->json(['success' => false, 'message' => 'Usuario o contraseña incorrectos'], 401);
    }
}