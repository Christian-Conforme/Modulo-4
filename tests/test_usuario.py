# import pytest
# from .conftest import get_token

# @pytest.mark.asyncio
# async def test_crud_usuario(async_client):
#     token = await get_token(async_client)
#     headers = {"Authorization": f"Bearer {token}"}

#     # Primero crea un empleado y un rol para las FK
#     empleado = {
#         "nombre": "Empleado User",
#         "cargo": "Cargo",
#         "correo": "empleado@user.com",
#         "telefono": "111222333"
#     }
#     rol = {"nombre": "RolUser"}
#     emp_resp = await async_client.post("/empleados/", json=empleado, headers=headers)
#     rol_resp = await async_client.post("/roles/", json=rol, headers=headers)
#     emp_id = emp_resp.json()["id_empleado"]
#     rol_id = rol_resp.json()["id_rol"]

#     # CREATE
#     data = {
#         "username": "usuario1",
#         "contrasena": "password123",
#         "empleado_id": emp_id,
#         "rol_id": rol_id
#     }
#     resp = await async_client.post("/usuarios/", json=data, headers=headers)
#     assert resp.status_code == 200
#     usuario = resp.json()
#     assert usuario["username"] == "usuario1"

#     # READ
#     resp = await async_client.get(f"/usuarios/{usuario['id_usuario']}", headers=headers)
#     assert resp.status_code == 200

#     # UPDATE
#     update = data.copy()
#     update["username"] = "usuario_actualizado"
#     resp = await async_client.put(f"/usuarios/{usuario['id_usuario']}", json=update, headers=headers)
#     assert resp.status_code == 200
#     assert resp.json()["username"] == "usuario_actualizado"

#     # DELETE
#     resp = await async_client.delete(f"/usuarios/{usuario['id_usuario']}", headers=headers)
#     assert resp.status_code == 200