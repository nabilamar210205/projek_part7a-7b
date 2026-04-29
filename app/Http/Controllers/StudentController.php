<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class StudentController extends Controller
{
    private $apiUrl = 'http://localhost:8000/api/student';
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Menampilkan daftar student dari API.
     */
    public function index(Request $request)
    {
        try {
            $page = $request->query('page', 1);
            $response = $this->client->get($this->apiUrl . '?page=' . $page);
            $body = json_decode($response->getBody(), true);

            $students   = $body['data']['data'] ?? [];
            $pagination = $body['data'] ?? [];

            // Fix pagination links: ganti URL API server menjadi URL client
            $links = $pagination['links'] ?? [];
            foreach ($links as &$link) {
                if ($link['url']) {
                    $link['url'] = str_replace(
                        'http://localhost:8000/api/student',
                        'http://localhost:8001/student',
                        $link['url']
                    );
                }
            }

            return view('student.index', [
                'students'   => $students,
                'pagination' => $pagination,
                'links'      => $links,
                'success'    => session('success'),
                'error'      => session('error'),
            ]);
        } catch (RequestException $e) {
            return view('student.index', [
                'students'   => [],
                'pagination' => [],
                'links'      => [],
                'error'      => 'Gagal mengambil data dari API Server. Pastikan API Server berjalan di port 8000.',
            ]);
        }
    }

    /**
     * Menyimpan data student baru via API.
     */
    public function store(Request $request)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'form_params' => $request->all(),
            ]);

            $body = json_decode($response->getBody(), true);

            return redirect('/student')->with('success', $body['message'] ?? 'Data student berhasil ditambahkan');
        } catch (RequestException $e) {
            $errors = [];
            $message = 'Gagal menyimpan data student.';

            if ($e->hasResponse()) {
                $responseBody = json_decode($e->getResponse()->getBody(), true);
                $message = $responseBody['message'] ?? $message;
                $errors = $responseBody['errors'] ?? [];
            }

            return redirect('/student')
                ->with('error', $message)
                ->with('validation_errors', $errors)
                ->withInput();
        }
    }

    /**
     * Menampilkan form edit student.
     */
    public function edit(string $id)
    {
        try {
            $response = $this->client->get($this->apiUrl . '/' . $id);
            $body = json_decode($response->getBody(), true);

            $student = $body['data'];

            return view('student.edit', [
                'student' => $student,
            ]);
        } catch (RequestException $e) {
            return redirect('/student')->with('error', 'Data student tidak ditemukan.');
        }
    }

    /**
     * Mengupdate data student via API.
     */
    public function update(Request $request, string $id)
    {
        try {
            $response = $this->client->put($this->apiUrl . '/' . $id, [
                'form_params' => $request->all(),
            ]);

            $body = json_decode($response->getBody(), true);

            return redirect('/student')->with('success', $body['message'] ?? 'Data student berhasil diupdate');
        } catch (RequestException $e) {
            $errors = [];
            $message = 'Gagal mengupdate data student.';

            if ($e->hasResponse()) {
                $responseBody = json_decode($e->getResponse()->getBody(), true);
                $message = $responseBody['message'] ?? $message;
                $errors = $responseBody['errors'] ?? [];
            }

            return redirect('/student/' . $id . '/edit')
                ->with('error', $message)
                ->with('validation_errors', $errors)
                ->withInput();
        }
    }

    /**
     * Menghapus data student via API.
     */
    public function destroy(string $id)
    {
        try {
            $response = $this->client->delete($this->apiUrl . '/' . $id);
            $body = json_decode($response->getBody(), true);

            return redirect('/student')->with('success', $body['message'] ?? 'Data student berhasil dihapus');
        } catch (RequestException $e) {
            return redirect('/student')->with('error', 'Gagal menghapus data student.');
        }
    }
}
