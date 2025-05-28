# import pytest
# from httpx import AsyncClient
# from app.main import app  # Ajusta el import según tu estructura

# import pytest_asyncio

# @pytest_asyncio.fixture
# async def async_client():
#     async with AsyncClient(base_url="http://test") as ac:
#         yield ac

# async def get_token(async_client):
#     login_data = {
#         "username": "admin",
#         "password": "admin123"
#     }
#     resp = await async_client.post("/auth/login", json=login_data)
#     assert resp.status_code == 200
#     return resp.json()["access_token"]