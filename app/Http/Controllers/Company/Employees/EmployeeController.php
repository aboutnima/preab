<?php

namespace App\Http\Controllers\Company\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Employees\StoreEmployeeRequest;
use App\Http\Requests\Company\Employees\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class EmployeeController extends Controller
{
    /**
     * List all employees for the authenticated company.
     */
    public function index(): Response
    {
        $employees = auth('company')->user()
            ->employees()
            ->orderByDesc('created_at')
            ->get(['id', 'first_name', 'last_name', 'email', 'gender', 'username', 'is_active', 'created_at']);

        return inertia('Company/Employees/Index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Employees'],
            ],
            'employees' => $employees,
        ]);
    }

    /**
     * Show the create employee form.
     */
    public function create(): Response
    {
        return inertia('Company/Employees/Create', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Employees', 'href' => route('company.employees.index')],
                ['label' => 'Add Employee'],
            ],
        ]);
    }

    /**
     * Store a new employee under the authenticated company.
     */
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        auth('company')->user()->employees()->create($request->validated());

        return redirect()->route('company.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Show the edit form for a company employee.
     */
    public function edit(Employee $employee): Response
    {
        $this->authorizeEmployee($employee);

        return inertia('Company/Employees/Edit', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Employees', 'href' => route('company.employees.index')],
                ['label' => $employee->first_name.' '.$employee->last_name],
            ],
            'employee' => $employee->only('id', 'first_name', 'last_name', 'email', 'gender', 'username', 'bio', 'is_active'),
        ]);
    }

    /**
     * Update an existing company employee.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $this->authorizeEmployee($employee);

        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password'], $data['password_confirmation']);
        }

        $employee->update($data);

        return back()->with('success', 'Employee updated successfully.');
    }

    /**
     * Delete a company employee.
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        $this->authorizeEmployee($employee);

        $employee->delete();

        return redirect()->route('company.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * Abort if the employee does not belong to the authenticated company.
     */
    private function authorizeEmployee(Employee $employee): void
    {
        abort_unless(
            $employee->company_id === auth('company')->id(),
            403,
        );
    }
}
