# import pytest
# import pytest_asyncio
# from .conftest import get_token

# @pytest.mark.asyncio
# async def test_crud_empleado(async_client):
#     token = await get_token(async_client)
#     headers = {"Authorization": f"Bearer {token}"}

#     # CREATE
#     data = {
#         "nombre": "Juan Test",
#         "cargo": "Tester",
#         "correo": "juan@test.com",
#         "telefono": "123456789"
#     }
#     resp = await async_client.post("/empleados/", json=data, headers=headers)
#     assert resp.status_code == 200
#     empleado = resp.json()
#     assert empleado["nombre"] == "Juan Test"

#     # READ
#     resp = await async_client.get(f"/empleados/{empleado['id_empleado']}", headers=headers)
#     assert resp.status_code == 200

#     # UPDATE
#     update = data.copy()
#     update["nombre"] = "Juan Actualizado"
#     resp = await async_client.put(f"/empleados/{empleado['id_empleado']}", json=update, headers=headers)
#     assert resp.status_code == 200
#     assert resp.json()["nombre"] == "Juan Actualizado"

#     # DELETE
#     resp = await async_client.delete(f"/empleados/{empleado['id_empleado']}", headers=headers)
#     assert resp.status_code == 200